<?php

namespace App\Controllers;
use App\Models\Compra;
use App\Models\Detalle_compra;
use Irsyadulibad\DataTables\DataTables;

class Ctr_compra extends BaseController{
    private $pagina = 'compra';
    public function index(){
        $ins = new Compra();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'comprasDelMes' => $ins->comprasDelMes(),
            'totalComprado' => $ins->totalComprado(),
            'totalProductosComprados' => $ins->totalProductosComprados(),
            'titulo'   =>  'Listado de compra',
            'pagina'    =>  'compra',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('compra')),
                    'name' => 'Listado de compras'
                )
            )
        ];

        if($data["esConsedido"]->leer){
            return view('html/compra/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $btn_acciones_list = getDisabledBtnAction($this->pagina);
            $table = db_connect()->table('compra');
            $datatable = $table->select('compra.*, 
            CONCAT(usuario.usuario) as usuario_nombre, 
            CONCAT(usuario.email) as usuario_email, 
            CONCAT(persona.nombre_completo) as proveedor, 
            compra.idcompra as compra_total,
            (select sum(detalle_compra.cantidad) from detalle_compra where detalle_compra.idcompra = compra.idcompra) as cantidad_pedido
            ');
            $datatable->join('usuario', 'usuario.idusuario = compra.idusuario');
            $datatable->join('persona', 'persona.idpersona = compra.idpersona');

            $queryFiltro = json_decode($this->request->getGetPost()['filtros_activos']) ?? [];
            $queryFechas = $queryFiltro->fecha ?? '';
            $queryEstado = $queryFiltro->idproveedor ?? '';

            if($queryFechas){
                $fechasList = explode(',',$queryFechas);
                $fechai = ltrim($fechasList[0] ?? '');
                $fechaf = ltrim($fechasList[1]) ?? '';
                if($fechai && $fechaf){
                    $datatable->where("compra.fecha BETWEEN '$fechai' AND '$fechaf'");
                }
            }
            
            if($queryEstado != ''){
                $datatable->where("compra.idpersona", $queryEstado);
            }

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('compra.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idcompra);
                    })
                    ->editColumn('compra_total', function($value, $data) {
                        $ins = new Compra();
                        $sumCompra = $ins->getSumCompra($data->idcompra);
                        if($sumCompra['resp']){
                            $totales = $sumCompra['data'];
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
                    ->rawColumns(['accion','compra_total'])
                    ->make(false);
            }else{
                $datatable->where('compra.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) use ($btn_acciones_list){
                        return btn_acciones($btn_acciones_list , base_url(route_to('compra.editar', $data->idcompra)), $data->idcompra);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idcompra.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
                    })
                    ->editColumn('compra_total', function($value, $data) {
                        $ins = new Compra();
                        $sumCompra = $ins->getSumCompra($data->idcompra);
                        if($sumCompra['resp']){
                            $totales = $sumCompra['data'];
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
                    ->rawColumns(['accion', 'estado','compra_total'])
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
            'pagina'    =>  'compra',
            'action'    =>  'add',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('compra')),
                    'name' => 'Listado de compras'
                ),
                array(
                    'url' => base_url(route_to('compra.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/compra/crear', $data);
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
            'pagina'    =>  'compra',
            'action'    =>  'edit',
            'id'        =>  'idcompra',
            'idValue'   =>  $id,
            'data'      =>  $this->getCompra($id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('compra')),
                    'name' => 'Listado de compras'
                )
            )
        ];

        if($data["esConsedido"]->modificar){
            return view('html/compra/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function getCompra($id){
        $ins = new Compra();
        $cabecera = $ins->where('idcompra', $id)
        ->join('persona', 'persona.idpersona = compra.idpersona')
        ->select('compra.*, persona.nombre_completo as nombreCliente')->first();

        $insDetalle = new Detalle_compra();
        $detalle = $insDetalle->where('idcompra', $id)
        ->join('producto', 'producto.idproducto = detalle_compra.idproducto')
        ->select('detalle_compra.*, producto.nombre as nombreProducto, producto.imagen as imagen')->findAll();
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
        $ins = new Compra();
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

    private function addCabeceraCompra($data){
        try {
            $ins = new Compra();
            $dataCompra = [
                "idusuario" => session('usuario')['idusuario'],
                "idpersona" => $data["proveedor"]["id"],
                "fecha" => $data["fecha"],
                "estado" => 1,
            ];
            $ins->insert($dataCompra);
            return $ins->getInsertID();
        } catch (\Exception $e) {
            $e->getMessage();
            return null;
        }
    }

    private function addDetalleCompra($data, $idCompra){
        try {
            $ins = new Detalle_compra();
            $insMultiple = [];
            foreach ($data as $key => $value) {
                $insMultiple[] = [
                    "idcompra" => $idCompra,
                    "idproducto" => $value["idProducto"],
                    "cantidad" => $value["cantidad"],
                    "precio_compra" => $value["precioCompra"],
                    "iva" => 15,
                    // "total" => $value["cantidad"] * $value["precioCompra"]
                ];
            }

            $ins->insertBatch($insMultiple);
            return true;
        } catch (\Exception $e) {
            $e->getMessage();
            return null;
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $respCompra = $this->addCabeceraCompra($data->compra["cabecera"]);
            if(!$respCompra){
                return false;
            }

            $idCompra = $respCompra;
            
            $respDetalle = $this->addDetalleCompra($data->compra["detalle"], $idCompra);
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
            $respCabecera = $this->editCabeceraCompra($id, $data->compra["cabecera"]);
            if(!$respCabecera){
                return false;
            }
            
            $insDetalle = new Detalle_compra();
            $respDetalle = $insDetalle->where('idcompra', $id)->delete();
            if(!$respDetalle){
                return false;
            }

            $respDetalle = $this->addDetalleCompra($data->compra["detalle"], $id);
            if(!$respDetalle){
                return false;
            }
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function editCabeceraCompra($id, $data){
        try {
            $ins = new Compra();

            $dataCompra = [
                "idempresa" => session('empresa')['idempresa'],
                "idpersona" => $data["proveedor"]["id"],
                "fecha" => $data["fecha"]
            ];
            $ins->update($id, $dataCompra);
            return $id;
        } catch (\Exception $e) {
            $e->getMessage();
            return null;
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Compra();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE compra set deleted_at = NULL where idcompra='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE compra set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idcompra='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Compra();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idcompra");
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
