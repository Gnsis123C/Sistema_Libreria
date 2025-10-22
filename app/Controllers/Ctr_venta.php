<?php

namespace App\Controllers;
use App\Models\Venta;
use App\Models\Detalle_venta;
use Irsyadulibad\DataTables\DataTables;

class Ctr_venta extends BaseController{
    private $pagina = 'venta';
    public function index(){
        $ins = new Venta();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'ventasDelMes' => $ins->ventasDelMes(),
            'totalVentas' => $ins->totalVentas(),
            'totalProductosVentas' => $ins->totalProductosVentas(),
            'titulo'   =>  'Listado de venta',
            'pagina'    =>  'venta',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('venta')),
                    'name' => 'Listado de ventas'
                )
            )
        ];

        if($data["esConsedido"]->leer){
            return view('html/venta/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $btn_acciones_list = getDisabledBtnAction($this->pagina);
            $table = db_connect()->table('venta');
            $datatable = $table->select('venta.*, 
            CONCAT(usuario.usuario) as usuario_nombre, 
            CONCAT(usuario.email) as usuario_email, 
            CONCAT(persona.nombre_completo) as cliente, 
            venta.idventa as venta_total,
            (select sum(detalle_venta.cantidad) from detalle_venta where detalle_venta.idventa = venta.idventa) as cantidad_pedido
            ');
            $datatable->join('usuario', 'usuario.idusuario = venta.idusuario');
            $datatable->join('persona', 'persona.idpersona = venta.idpersona');

            $queryFiltro = json_decode($this->request->getGetPost()['filtros_activos']) ?? [];
            $queryFechas = $queryFiltro->fecha ?? '';
            $queryEstado = $queryFiltro->idcliente ?? '';

            if($queryFechas){
                $fechasList = explode(',',$queryFechas);
                $fechai = ltrim($fechasList[0] ?? '');
                $fechaf = ltrim($fechasList[1]) ?? '';
                if($fechai && $fechaf){
                    $datatable->where("venta.fecha BETWEEN '$fechai' AND '$fechaf'");
                }
            }
            
            if($queryEstado != ''){
                $datatable->where("venta.idpersona", $queryEstado);
            }

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('venta.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idventa);
                    })
                    ->editColumn('venta_total', function($value, $data) {
                        $ins = new Venta();
                        $sumVenta = $ins->getSumVenta($data->idventa);
                        if($sumVenta['resp']){
                            $totales = $sumVenta['data'];
                            return '<table class="table table-sm mb-0 table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="">Número de productos</td>
                                        <td class="text-end">' . $totales['productos'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="">Subtotal</td>
                                        <td class="text-end"> $' . round($totales['total_sin_iva'], 2) . '</td>
                                    </tr>
                                    <tr>
                                        <td class="">IVA (15%)</td>
                                        <td class="text-end"> $' . round(($totales['total_con_iva'] - $totales['total_sin_iva']), 2) . '</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td class="">Total + IVA</td>
                                        <td class="text-end"> $' . round($totales['total_con_iva'], 2) . '</td>
                                    </tr>
                                </tbody>
                            </table>';
                        }else{
                            return '';
                        }
                    })
                    ->rawColumns(['accion','venta_total'])
                    ->make(false);
            }else{
                $datatable->where('venta.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) use ($btn_acciones_list){
                        return btn_acciones($btn_acciones_list , base_url(route_to('venta.editar', $data->idventa)), $data->idventa);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idventa.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
                    })
                    ->editColumn('venta_total', function($value, $data) {
                        $ins = new Venta();
                        $sumVenta = $ins->getSumVenta($data->idventa);
                        if($sumVenta['resp']){
                            $totales = $sumVenta['data'];
                            return '<table class="table table-sm mb-0 table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="">Número de productos</td>
                                        <td class="text-end">' . $totales['productos'] . '</td>
                                    </tr>
                                    <tr>
                                        <td class="">Subtotal</td>
                                        <td class="text-end"> $' . round($totales['total_sin_iva'], 2) . '</td>
                                    </tr>
                                    <tr>
                                        <td class="">IVA (15%)</td>
                                        <td class="text-end"> $' . round(($totales['total_con_iva'] - $totales['total_sin_iva']), 2) . '</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td class="">Total + IVA</td>
                                        <td class="text-end"> $' . round($totales['total_con_iva'], 2) . '</td>
                                    </tr>
                                </tbody>
                            </table>';
                        }else{
                            return '';
                        }
                    })
                    ->rawColumns(['accion', 'estado','venta_total'])
                    ->make(false);
            }
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function crear(){
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   =>  'Crear registro',
            'pagina'    =>  'venta',
            'action'    =>  'add',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('venta')),
                    'name' => 'Listado de ventas'
                ),
                array(
                    'url' => base_url(route_to('venta.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/venta/crear', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    public function editar($id){
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   =>  'Editar registro',
            'pagina'    =>  'venta',
            'action'    =>  'edit',
            'id'        =>  'idventa',
            'idValue'   =>  $id,
            'data'      =>  $this->getVenta($id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('venta')),
                    'name' => 'Listado de ventas'
                )
            )
        ];

        if($data["esConsedido"]->modificar){
            return view('html/venta/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function getVenta($id){
        $ins = new Venta();
        $cabecera = $ins->where('idventa', $id)
        ->join('persona', 'persona.idpersona = venta.idpersona')
        ->select('venta.*, persona.nombre_completo as nombreCliente')->first();

        $insDetalle = new Detalle_venta();
        $detalle = $insDetalle->where('idventa', $id)
        ->join('producto', 'producto.idproducto = detalle_venta.idproducto')
        ->select('detalle_venta.*, producto.nombre as nombreProducto, producto.imagen as imagen')->findAll();
        return [
            "cabecera" => $cabecera,
            "detalle" => $detalle
        ];
    }

    //ENDPOINDS
    public function action() {
        $post = (object) $this->request->getGetPost();
        $data = [];
        switch ($post->action) {
            case 'list':
                return $this->listar();
                break;
            case 'del':
                return $this->response->setJSON( [
                    "resp" => $this->delete($post->id)
                ] );
                break;
            case 'restore':
                return $this->response->setJSON( [
                    "resp" => $this->restore($post->id)
                ] );
                break;
            case 'estado':
                return $this->response->setJSON( [
                    "resp" => $this->estado($post->id, $post)
                ] );
                break;
            case 'add':
                return $this->response->setJSON( [
                    "resp" => $this->add($post)
                ] );
                break;
            case 'edit':
                return $this->response->setJSON( [
                    "resp" => $this->edit($post->id, $post)
                ] );
                break;

            default:
                $this->response->setStatusCode(404, 'Error con la petición');
                break;
        }
    }

    public function nombre() {
        $post = (object) $this->request->getGetPost();
        $ins = new Venta();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->nombre), 'nombre')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'nombre'=> strtoupper($post->nombre)
                )
            )));
            exit();
        }
    }

    private function addCabeceraVenta($data){
        try {
            $ins = new Venta();
            $dataVenta = [
                "idusuario" => session('usuario')['idusuario'],
                "idpersona" => $data["cliente"]["id"],
                "fecha" => $data["fecha"],
                "precio_total" => $data["subtotal"],
                "estado" => 1,
            ];
            $ins->insert($dataVenta);
            return $ins->getInsertID();
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return null;
        }
    }

    private function addDetalleVenta($data, $idVenta, $fecha){
        try {
            $ins = new Detalle_venta();
            $insMultiple = [];
            foreach ($data as $key => $value) {
                $insMultiple[] = [
                    "idventa" => $idVenta,
                    "idproducto" => $value["idProducto"],
                    "cantidad" => $value["cantidad"],
                    "precio_venta" => $value["precioVenta"],
                    "temporada" => obtenerTemporadaEcuador($fecha)['id'] ?? 'normal',
                    "iva" => 15,
                    // "total" => $value["cantidad"] * $value["precioVenta"]
                ];
            }

            $ins->insertBatch($insMultiple);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $respVenta = $this->addCabeceraVenta($data->venta["cabecera"]);
            if(!$respVenta){
                return false;
            }

            $idVenta = $respVenta;
            $ins = new Venta();
            $dataVenta = [
                "numero_factura" => str_pad($idVenta, 6, '0', STR_PAD_LEFT)
            ];
            $ins->update($idVenta, $dataVenta);
            
            $respDetalle = $this->addDetalleVenta($data->venta["detalle"], $idVenta, $data->venta["cabecera"]["fecha"]);
            if(!$respDetalle){
                return false;
            }
            
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $respCabecera = $this->editCabeceraVenta($id, $data->venta["cabecera"]);
            if(!$respCabecera){
                return false;
            }
            
            // $insDetalle = new Detalle_venta();
            // $respDetalle = $insDetalle->where('idventa', $id)->delete();

            $db = db_connect();
            $db->query('DELETE FROM detalle_venta where idventa='.$id);

            if(!$respDetalle){
                return false;
            }

            $respDetalle = $this->addDetalleVenta($data->venta["detalle"], $id);
            if(!$respDetalle){
                return false;
            }
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function editCabeceraVenta($id, $data){
        try {
            $ins = new Venta();

            $dataVenta = [
                // "idusuario" => session('usuario')['idusuario'],
                "idpersona" => $data["cliente"]["id"],
                "fecha" => $data["fecha"],
                "precio_total" => $data["subtotal"],
                "estado" => 1,
            ];
            $ins->update($id, $dataVenta);
            return $id;
        } catch (\Exception $e) {
            $e->getMessage();
            return null;
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            // $ins = new Venta();
            // return $ins->delete($id);
            $db = db_connect();
            $db->query('DELETE FROM venta where idventa='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE venta set deleted_at = NULL where idventa='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE venta set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idventa='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Venta();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idventa");
        //->where('idusuario', session('usuario')['idusuario']);//

        if (!empty($searchTerm)) {
            $builder->groupStart()
                ->like("CONCAT( nombre )", $searchTerm)
                // ->orLike('logo', $searchTerm)
                ->groupEnd();
        }

        // Cláusula de ordenamiento
        $builder->orderBy('nombre', 'ASC');

        // Paginación
        $offset = ($page - 1) * $size;
        $query = $builder->get($size, $offset);

        // Conteo total de registros (optimizado)
        $totalBuilder = clone $builder;
        $count_filtered = $totalBuilder->countAllResults();

        return $this->response->setJSON([
            'results' => $query->getResult(),
            'count_filtered' => $count_filtered,
            'size' => $size,
            'page' => $page
        ]);
    }

    private function editarArray($post) {
        date_default_timezone_set('America/Guayaquil');
        setlocale(LC_ALL, 'es_ES');
        $fecha = date('Y-m-d', time());
        $hora = date("H:m:s", time());
        $data = array(
            'idempresa' => strtoupper($post->idempresa),
            'nombre'    => strtoupper($post->nombre),
            'estado'    => strtoupper($post->estado)
        );
        if($post->action == 'add'){
            $data['created_at'] = date('Y-m-d H:m:s', time());
        }
        if($post->action == 'edit'){
            $data['updated_at'] = date('Y-m-d H:m:s', time());
        }
        return $data;
    }
}
