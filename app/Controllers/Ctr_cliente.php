<?php

namespace App\Controllers;
use App\Models\Cliente;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_cliente extends BaseController{
    public function index(){
        $ins = new Cliente();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "ver" => true
            ],
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de cliente/persona',
            'pagina'    =>  'cliente',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('cliente')),
                    'name' => 'Listado de clientes'
                )
            )
        ];

        if($data["esConsedido"]->ver){
            return view('html/cliente/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $table = db_connect()->table('cliente');
            $datatable = $table->select('cliente.*, CONCAT(empresa.nombre) as empresa');
            $datatable->join('empresa', 'cliente.idempresa = empresa.idempresa');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('cliente.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idcliente);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('cliente.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['all'] , base_url(route_to('cliente.editar', $data->idcliente)), $data->idcliente);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idcliente.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
                    })
                    ->editColumn('tipo', function($value, $data) {
                        return tipoCliente($value);
                    })
                    ->rawColumns(['accion', 'estado', 'tipo'])
                    ->make(false);
            }
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function crear(){
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "crear" => true
            ],
            'titulo'   =>  'Crear registro',
            'pagina'    =>  'cliente.crear',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('cliente')),
                    'name' => 'Listado de clientes'
                ),
                array(
                    'url' => base_url(route_to('cliente.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/cliente/crear', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    public function editar($id){
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "editar" => true
            ],
            'titulo'   =>  'Editar registro',
            'pagina'    =>  'cliente.editar',
            'action'    =>  'edit',
            'id'        =>  'idcliente',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('cliente')),
                    'name' => 'Listado de clientes'
                )
            )
        ];

        if($data["esConsedido"]->editar){
            return view('html/cliente/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function atributosForm($action, $id){
        $data = array();
        $listaExcluir = [];
        $empresa = [
            "id" => "",
            "text" => ""
        ];
        $cliente = new Cliente();
        if($action == 'editar'){
            $data = $cliente->find($id);
            $getEmpresa = new Empresa();
            $getEmpresa = (new Empresa())->find($data['idempresa']);
            if($getEmpresa){
                $empresa = [
                    "id" => $getEmpresa['idempresa'],
                    "text" => "#" . str_pad($getEmpresa['idempresa'], 4, "0", STR_PAD_LEFT) . " - " . $getEmpresa['nombre']
                ];
            }
            
            /*if($id == '1' || $id == '2'){
                $listaExcluir = ['nombre'];
            }*/
        }
        $atributosLista = array(
            array(
                'name' => 'id',
                'type' => 'hidden',
                'value' => ($action == 'editar'?$id:''),
                'max' => 100,
                'title' => '',
                'requerido' => true
            ),
            array(
                'name' => 'logo',
                'type' => 'hidden',
                'value' => "logo-cr-svg-blanco.svg?v=1",
                'max' => 100,
                'title' => '',
                'requerido' => true
            ),
            array(
                'name' => 'nombre',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['nombre']:''),
                'max' => 100,
                'title' => 'Escribe sus nombres',
                'placeholder' => 'Escribe sus nombres',
                'requerido' => true
            ),
            array(
                'name' => 'ci',
                'type' => 'number',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'?$data['ci']:''),
                'max' => 10,
                'title' => 'Cédula de identidad',
                'placeholder' => 'Cédula de identidad',
                'requerido' => true
            ),
            
            array(
                'name' => 'idempresa',
                'url' => (route_to('empresa')),
                'url_select' => base_url(route_to('empresa.select')),
                'theme' => 'bootstrap4',
                'results' => array(
                    'id'  =>  'idempresa',
                    'text'  =>  'nombre' 
                ),
                'option' => array(
                    array(
                        'value' => ($action == 'editar'? $empresa['id']:''),
                        'text' => ($action == 'editar'? $empresa['text']:''),
                        'selected' => true,
                        'attr' => array(
                            'text' => '',
                            'value' => ''
                        )
                    )
                ),
                'title' => 'Seleccionar empresa',
                'requerido' => true,
                'type' => 'selectajax',
                'per_page' => 10,
                'column' => 'col-md-12',
            ),
            array(
                'name' => 'tipo',
                'title' => 'Tipo de persona',
                'requerido' => true,
                'type' => 'select', //num
                'option' => array(
                    array(
                        'value' => '0',
                        'text' => 'Cliente',
                        'selected' => ($action == 'editar'?($data['tipo']=='cliente'?true:false):''),
                        'attr' => array(
                            'text' => '',
                            'value' => ''
                        )
                    ),
                    array(
                        'value' => '1',
                        'text' => 'Proveedor',
                        'selected' => ($action == 'editar'?($data['tipo']=='proveedor'?true:false):''),
                        'attr' => array(
                            'text' => '',
                            'value' => ''
                        )
                    )
                )
            ),
            array(
                'name' => 'estado',
                'title' => 'Estado del cliente',
                'requerido' => true,
                'type' => 'select', //num
                'option' => array(
                    array(
                        'value' => '1',
                        'text' => 'Activo',
                        'selected' => ($action == 'editar'?($data['estado']=='1'?true:false):''),
                        'attr' => array(
                            'text' => 's',
                            'value' => '3'
                        )
                    ),
                    array(
                        'value' => '0',
                        'text' => 'Inactivo',
                        'selected' => ($action == 'editar'?($data['estado']=='0'?true:false):''),
                        'attr' => array(
                            'text' => '3',
                            'value' => '3'
                        )
                    )
                )
            ),
        );

        return excluirCR($atributosLista, $listaExcluir);
    }

    //ENDPOINDS
    public function action() {
        $post = (object) $this->request->getGetPost();
        $data = [];
        if($post->action == 'add' || $post->action == 'edit') $data = $this->editarArray($post);
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
                    "resp" => $this->add($data)
                ] );
                break;
            case 'edit':
                return $this->response->setJSON( [
                    "resp" => $this->edit($post->id, $data)
                ] );
                break;

            default:
                $this->response->setStatusCode(404, 'Error con la petición');
                break;
        }
    }

    public function ci() {
        $post = (object) $this->request->getGetPost();
        $ins = new Cliente();
        if ($post->id == '0') {
            if($post->ci == '0000000000'){
                echo json_encode(array('valid' => true));
                exit();
            }
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->ci), 'ci')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'ci'=> strtoupper($post->ci)
                )
            )));
            exit();
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Cliente();//->getInsertID();
            $estado = $ins->insert($data, false);
            $id = $ins->getInsertID();
            return $estado;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Cliente();
            return $ins->update($id, $data);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Cliente();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE cliente set deleted_at = NULL where idcliente='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE cliente set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idcliente='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Cliente();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idcliente, logo");
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

    public function selectBDProveedor(){
        $modelLocal = new Cliente();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idcliente")
        ->where('tipo', 1);//

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
            'ci'        => strtolower($post->ci),
            'tipo'      => strtoupper($post->tipo),
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
