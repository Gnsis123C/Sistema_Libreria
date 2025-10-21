<?php

namespace App\Controllers;
use App\Models\Rol;
use App\Models\Detalle_rol;
use Irsyadulibad\DataTables\DataTables;

class Ctr_rol extends BaseController{
    private $pagina = 'rol';
    public function index(){
        $ins = new Rol();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de roles del sistema',
            'pagina'    =>  'rol',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('iniciar')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Administración de roles'
                )
            )
        ];

        if($data["esConsedido"]->leer){
            return view('html/rol/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    // Tabla de rols
    private function listar(){
        if ($this->request->isAJAX()) {
            $btn_acciones_list = getDisabledBtnAction($this->pagina);
            $table = db_connect()->table('rol');
            $datatable = $table
                ->select('rol.*')
                ->orderBy('idrol', 'desc');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('rol.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idrol);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('rol.deleted_at' , null);
                if($this->request->getGetPost()['idrol'] != ""){
                    $datatable->where('rol.idrol', $this->request->getGetPost()['idrol']);
                }
                return datatables($datatable)
                    ->addColumn('accion', function($data) use ($btn_acciones_list) {
                        $disabled = [1];
                        return btn_acciones(
                            $btn_acciones_list , 
                            base_url(route_to('rol.editar', $data->idrol)), 
                            $data->idrol, 
                            in_array($data->idrol, $disabled) ? 'disabled':'',
                            [
                                [
                                    "text" => "Asignación de accesos y permisos",
                                    "name" => "asignacion-perfil",
                                    "value" => $data->idrol,
                                    "icon" => "fas fa-cogs"
                                ]
                            ]
                        );
                    })
                    ->rawColumns(['accion'])
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
            'titulo'   =>  'Crear rol',
            'subtitulo'   =>  'Nuevo registro de rol',
            'pagina'    =>  'rol',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),

            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Administración de rol'
                ),
                array(
                    'url' => base_url(route_to('rol.crear')),
                    'name' => 'Crear registro del rol'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/rol/crear', $data);
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
            'titulo'   =>  'Editar rol',
            'pagina'    =>  'rol',
            'action'    =>  'edit',
            'id'        =>  'idrol',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Administración de rol'
                ),
                array(
                    'url' => base_url(route_to('rol')),
                    'name' => 'Editar rol'
                )
            )
        ];

        if($data["esConsedido"]->modificar){
            return view('html/rol/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function atributosForm($action, $id){
        $data = array();
        $listaExcluir = [];
        $rol = [
            "id" => "",
            "text" => ""
        ];
        
        if($action == 'editar'){
            $data = (new Rol())->find($id);
            $listaExcluir[] = "pass";
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
                'name' => 'nombre',
                'type' => 'nickname',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['nombre']:''),
                'max' => 100,
                'title' => 'Nombre completo',
                'placeholder' => 'Ingrese el nombre completo del rol',
                'requerido' => true
            )
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
                return $this->response->setJSON( $this->add($data) );
                break;
            case 'edit':
                return $this->response->setJSON( $this->edit($post->id, $data) );
                break;
            case 'get.permisos':
                return $this->response->setJSON( $this->getPermisos($post->id) );
                break;
            case 'post.permisos':
                return $this->response->setJSON( $this->editarPermisos($post) );
                break;
            case 'reset.permisos':
                return $this->response->setJSON( $this->resetPermisos($post) );
                break;

            default:
                $this->response->setStatusCode(404, 'Error con la petición');
                break;
        }
    }

    private function editarPermisos($post){
        $iddetalle_rol = $post->iddetalle_rol ?? 0;
        $tipo = $post->tipo ?? 'leer';
        $estado = $post->estado ?? 0;
        $ins = new Detalle_rol();
        $ins->update($iddetalle_rol, [
            $tipo => $estado,
            'updated_at' => date('Y-m-d H:i:s', time())
        ], false);
        return [
            'resp' => true
        ] ?? [];
    }

    private function resetPermisos($post){
        $idrol = $post->id ?? 0;
        $db = db_connect();
        $db->query('DELETE FROM detalle_rol WHERE idrol = '.$idrol);
        $db->query('call sp_crear_accesos_rol('.$idrol.');');
        return [
            'resp' => true
        ] ?? [];
    }

    private function getPermisos($idrol){
        $ins = new Detalle_rol();
        return [
            'resp' => true,
            'data' => $ins->getPermisos($idrol)
        ] ?? [];
    }

    public function nombre() {
        $post = (object) $this->request->getGetPost();

        $ins = new Rol();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtolower($post->nombre), 'nombre')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'nombre'=> strtolower($post->nombre)
                )
            )));
            exit();
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Rol();//->getInsertID();
            $estado = $ins->insert($data['rol'], false);
            return [
                'resp' => true
            ];
        }else{
            return [
                'resp' => false,
                'error' => 'Error con la petición'
            ];
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Rol();
            $ins->update($id, $data['rol'], false);
            return [
                'resp' => true
            ];
        }else{
            return [
                'resp' => false,
                'error' => 'Error con la petición'
            ];
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Rol();
            $ins->delete($id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE rol set deleted_at = NULL where idrol='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE rol set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idrol='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
            return false;
        }
    }

    public function selectBD(){
        $modelLocal = new Rol();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();

        $builder->select("CONCAT( nombre ) AS nombre, idrol as id");

        if (!empty($searchTerm)) {
            $builder->groupStart()
                ->like("CONCAT( nombre )", $searchTerm)
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
        $dateTime = date('Y-m-d H:m:s', time());
        $hora = date("H:m:s", time());

        $dataRol = [];

        $dataRol = [
            'nombre' => strtolower($post->nombre),
        ];

        if($post->action == 'add'){
            $dataRol['created_at']   = $dateTime;
        }

        if($post->action == 'edit'){
            $dataRol['updated_at']   = $dateTime;
        }

        $data = [
            'rol' => $dataRol
        ];
        return $data;
    }
}
