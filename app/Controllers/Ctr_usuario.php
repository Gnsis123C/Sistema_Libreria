<?php

namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Rol;
use Irsyadulibad\DataTables\DataTables;

class Ctr_usuario extends BaseController{
    public function index(){
        $ins = new Usuario();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "ver" => true
            ],
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Usuario y asignación de roles',
            'pagina'    =>  'usuario',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('usuario')),
                    'name' => 'Administración de usuarios'
                )
            )
        ];

        if($data["esConsedido"]->ver){
            return view('html/usuario/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    // Tabla de usuarios
    private function listar(){
        if ($this->request->isAJAX()) {
            $table = db_connect()->table('usuario');
            $datatable = $table
                ->select('usuario.*, concat(rol.nombre) as nombre_rol')
                ->join('rol', 'rol.idrol=usuario.idrol');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('usuario.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idusuario);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return list_estado_acceso_sistema($value)['text'];
                    })
                    ->rawColumns(['accion','estado'])
                    ->make(false);
            }else{
                $datatable->where('usuario.deleted_at' , null);
                if($this->request->getGetPost()['idrol'] != ""){
                    $datatable->where('usuario.idrol', $this->request->getGetPost()['idrol']);
                }
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        $disabled = [1];
                        return btn_acciones(
                            ['all'] , 
                            base_url(route_to('usuario.editar', $data->idusuario)), 
                            $data->idusuario, 
                            in_array($data->idusuario, $disabled) ? 'disabled':'',
                            // [
                            //     [
                            //         "text" => "Asignación de accesos y permisos",
                            //         "name" => "asignacion-perfil",
                            //         "value" => 'idusuario:'.$data->idusuario.',idusuario:'.$data->idusuario.',idrol:'.$data->idrol,
                            //         "icon" => "fas fa-cogs"
                            //     ]
                            // ]
                        );
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar acceso al sistema" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idusuario.'" href="#">'.
                                    ($value=='1'?'<i class="fas fa-toggle-on fs-4"></i>':'<i class="fas fa-toggle-off fs-4"></i>').
                                '</a>'. '<span class="fw-bold text-primary small"> '.list_estado_acceso_sistema($value)['text'].' </span>';
                    })
                    ->rawColumns(['accion', 'estado'])
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
            'titulo'   =>  'Crear usuario',
            'subtitulo'   =>  'Nuevo registro de usuario',
            'pagina'    =>  'usuario.crear',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),

            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('usuario')),
                    'name' => 'Administración de usuario'
                ),
                array(
                    'url' => base_url(route_to('usuario.crear')),
                    'name' => 'Crear registro del usuario'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/usuario/crear', $data);
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
            'titulo'   =>  'Editar usuario',
            'pagina'    =>  'usuario.editar',
            'action'    =>  'edit',
            'id'        =>  'idusuario',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('usuario')),
                    'name' => 'Administración de usuario'
                ),
                array(
                    'url' => base_url(route_to('usuario')),
                    'name' => 'Editar usuario'
                )
            )
        ];

        if($data["esConsedido"]->editar){
            return view('html/usuario/editar', $data);
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
            $data = (new Usuario())->find($id);
            $insRol = (new Rol())->find($data['idrol']);
            $rol = [
                "id" => $insRol['idrol'],
                "text" => $insRol['nombre']
            ];
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
                'name' => 'idrol',
                'url_select' => base_url(route_to('rol.select')),
                'url' => base_url(route_to('rol.crear')),
                'theme' => 'bootstrap4',
                'results' => array(
                    'id'  =>  'id',
                    'text'  =>  'nombre' 
                ),
                'option' => array(
                    array(
                        'value' => ($action == 'editar'?$rol['id']:''),
                        'text' => ($action == 'editar'?('# '.str_pad($rol['id'], 4, "0", STR_PAD_LEFT). ' '.( $rol['text'] )):''),
                        'selected' => true,
                        'attr' => array(
                            'text' => '',
                            'value' => ''
                        )
                    )
                ),
                'title' => 'Seleccionar un rol',
                'requerido' => true,
                'type' => 'selectajax',
                'per_page' => 10,
                'column' => 'col-md-12',
            ),
            array(
                'name' => 'nombre',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['nombre']:''),
                'max' => 100,
                'title' => 'Nombre completo',
                'placeholder' => 'Ingrese el nombre completo del usuario',
                'requerido' => true
            ),
            array(
                'name' => 'usuario',
                'type' => 'nickname',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['usuario']:''),
                'max' => 20,
                'title' => 'Nick de usuario',
                'placeholder' => 'Ingrese el nick de usuario',
                'requerido' => true
            ),
            array(
                'name' => 'email',
                'type' => 'email',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['email']:''),
                'max' => 100,
                'title' => 'Correo Electrónico',
                'placeholder' => 'Ingrese el nombre del usuario',
                'requerido' => true
            ),
            array(
                'name' => 'pass',
                'type' => 'password',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['pass']:''),
                'max' => 100,
                'title' => 'Escriba su contraseña',
                'placeholder' => 'Escriba su contraseña',
                'requerido' => true
            ),
            array(
                'name' => 'estado',
                'title' => 'Estado de Acceso al Sistema',
                'requerido' => true,
                'type' => 'select', //num
                'option' => array_map(function($tipo) use ($action, $data){
                    $item = array(
                        'value' => $tipo['id'],
                        'text' => $tipo['text'],
                        'attr' => array(
                            'text' => 's',
                            'value' => '3'
                        )
                    );

                    if($action == 'editar' && $data['estado'] == $tipo['id']){
                        $item['selected'] = true;
                    }
                    return $item;
                }, list_estado_acceso_sistema()),
            ),
        );

        return excluirCR($atributosLista, $listaExcluir);
    }

    private function resetpass($id, $pass){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE usuario set pass = "'.password_hash($pass, PASSWORD_BCRYPT).'" where idusuario='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
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
            case 'pass':
                return $this->response->setJSON( [
                    "resp" => $this->resetpass($post->id, $post->pass)
                ] );
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
        // $idpermiso = $post->idpermiso ?? 0;
        // $tipo = $post->tipo ?? 'leer';
        // $estado = $post->estado ?? 0;
        // $ins = new Permiso();
        // $ins->update($idpermiso, [
        //     $tipo => $estado,
        //     'updated_at' => date('Y-m-d H:i:s', time())
        // ], false);
        // return [
        //     'resp' => true
        // ] ?? [];
    }

    private function resetPermisos($post){
        // $idusuario = $post->id ?? 0;
        // $db = db_connect();
        // $db->query('DELETE FROM usuario_permiso WHERE idusuario = '.$idusuario);
        // $db->query('call sp_crear_accesos_usuario('.$idusuario.');');
        // return [
        //     'resp' => true
        // ] ?? [];
    }

    private function getPermisos($idusuario){
        // $ins = new Usuario();
        // return [
        //     'resp' => true,
        //     'data' => $ins->getPermisos($idusuario)
        // ] ?? [];
    }

    public function usuario() {
        $post = (object) $this->request->getGetPost();

        $ins = new Usuario();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtolower($post->usuario), 'usuario')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'usuario'=> strtolower($post->usuario)
                )
            )));
            exit();
        }
    }

    public function email() {
        $post = (object) $this->request->getGetPost();
        $ins = new Usuario();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtolower($post->email), 'email')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'email'=> strtolower($post->email)
                )
            )));
            exit();
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Usuario();//->getInsertID();
            $estado = $ins->insert($data['usuario'], false);
            $idUsuario = $ins->getInsertID();
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
            $ins = new Usuario();
            $ins->update($id, $data['usuario'], false);
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
            $ins = new Usuario();
            $ins->delete($id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE usuario set deleted_at = NULL where idusuario='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE usuario set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idusuario='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
            return false;
        }
    }

    public function selectBD(){
        $modelLocal = new Usuario();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();

        $builder->select("CONCAT( email, ', ',nombre ) AS nombre, idusuario");

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

        $dataUsuario = [];

        $dataUsuario = [
            'nombre'    => strtoupper($post->nombre),
            'email'     => strtolower($post->email),
            'usuario'   => strtolower($post->usuario),
            'estado'    => $post->estado,
            'idrol'     => $post->idrol,
            'idempresa' => session('idempresa')['idempresa'] ?? 1
        ];

        if($post->action == 'add'){
            $dataUsuario['created_at']   = $dateTime;
            $dataUsuario['pass']       = password_hash($post->pass, PASSWORD_BCRYPT);
        }

        if($post->action == 'edit'){
            $dataUsuario['updated_at']   = $dateTime;
        }

        $data = [
            'usuario' => $dataUsuario
        ];
        return $data;
    }
}
