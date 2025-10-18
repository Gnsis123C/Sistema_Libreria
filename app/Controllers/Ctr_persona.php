<?php

namespace App\Controllers;
use App\Models\Persona;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_persona extends BaseController{
    private $pagina = 'cliente';

    public function index($pagina = 'cliente'){
        $this->pagina = $pagina;
        $titulo = 'Listado de persona';
        if($pagina == 'cliente'){
            $titulo = 'Listado de clientes';
        }else if($pagina == 'proveedor'){
            $titulo = 'Listado de proveedores';
        }else{
            return $this->response->setJSON([
                "resp" => false,
                "message" => "No tienes acceso"
            ]);
        }
        $ins = new Persona();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  $titulo,
            'pagina'    =>  $this->pagina,
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('persona', $this->pagina)),
                    'name' => 'Listado de '.$pagina
                )
            )
        ];

        if($data["esConsedido"]->leer){
            return view('html/persona/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $btn_acciones_list = getDisabledBtnAction($this->pagina);
            $table = db_connect()->table('persona');

            $tipo = '0';
            if($this->pagina == 'cliente'){
                $tipo = '0';
            }else if($this->pagina == 'proveedor'){
                $tipo = '1';
            }

            $datatable = $table->select('persona.*');
            $datatable->where('tipo' , $tipo);

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('persona.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idpersona);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('persona.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) use ($btn_acciones_list) {
                        return btn_acciones($btn_acciones_list , base_url(route_to('persona.editar', $this->pagina, $data->idpersona)), $data->idpersona);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idpersona.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
                    })
                    ->rawColumns(['accion', 'estado'])
                    ->make(false);
            }
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function crear($pagina = 'cliente'){
        $this->pagina = $pagina;
        $titulo = 'Crear persona para productos';
        if($pagina == 'cliente'){
            $titulo = 'Añadir cliente';
        }else if($pagina == 'proveedor'){
            $titulo = 'Añadir proveedores';
        }else{
            return $this->response->setJSON([
                "resp" => false,
                "message" => "No tienes acceso"
            ]);
        }
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   => $titulo,
            'pagina'    =>  $this->pagina,
            'action'    =>  'add',
            'attrform' => $this->personasForm('crear', 0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('persona.crear', $this->pagina)),
                    'name' => $titulo
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/persona/crear', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    public function editar($pagina = 'cliente', $id = '0'){
        $this->pagina = $pagina;
        $titulo = 'Editar persona';
        if($pagina == 'cliente'){
            $titulo = 'Editar cliente';
        }else if($pagina == 'proveedor'){
            $titulo = 'Editar proveedores';
        }else{
            return $this->response->setJSON([
                "resp" => false,
                "message" => "No tienes acceso"
            ]);
        }
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   =>  $titulo,
            'pagina'    =>  $this->pagina,
            'action'    =>  'edit',
            'id'        =>  'idpersona',
            'attrform' => $this->personasForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('persona', $this->pagina)),
                    'name' => 'Listado de '.$pagina
                )
            )
        ];

        if($data["esConsedido"]->modificar){
            return view('html/persona/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function personasForm($action, $id){
        $data = array();
        $tipo = 'Cédula';
        if($this->pagina == 'cliente'){
            $tipo = 'Cédula';
        }else if($this->pagina == 'proveedor'){
            $tipo = 'RUC';
        }

        $listaExcluir = [];
        $empresa = [
            "id" => "",
            "text" => ""
        ];
        $persona = new Persona();
        if($action == 'editar'){
            $data = $persona->find($id);
            /*if($id == '1' || $id == '2'){
                $listaExcluir = ['nombre'];
            }*/
        }
        $personasLista = array(
            array(
                'name' => 'id',
                'type' => 'hidden',
                'value' => ($action == 'editar'?$id:''),
                'max' => 100,
                'title' => '',
                'requerido' => true
            ),
            // array(
            //     'name' => 'idempresa',
            //     'url' => base_url(route_to('empresa')),
            //     'url_select' => base_url(route_to('empresa.select')),
            //     'theme' => 'bootstrap4',
            //     'results' => array(
            //         'id'  =>  'idempresa',
            //         'text'  =>  'nombre' 
            //     ),
            //     'option' => array(
            //         array(
            //             'value' => ($action == 'editar'? $empresa['id']:''),
            //             'text' => ($action == 'editar'? $empresa['text']:''),
            //             'selected' => true,
            //             'attr' => array(
            //                 'text' => '',
            //                 'value' => ''
            //             )
            //         )
            //     ),
            //     'title' => 'Seleccionar empresa',
            //     'requerido' => true,
            //     'type' => 'selectajax',
            //     'per_page' => 10,
            //     'column' => 'col-md-12',
            // ),
            array(
                'name' => 'nombre_completo',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['nombre_completo']:''),
                'max' => 100,
                'title' => 'Nombre completo',
                'placeholder' => 'Nombre completo',
                'requerido' => true
            ),
            array(
                'name' => 'email',
                'type' => 'email',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['email']:''),
                'max' => 100,
                'title' => 'Correo electrónico',
                'placeholder' => 'Correo electrónico',
                'requerido' => true
            ),
            array(
                'name' => 'telefono',
                'type' => 'number',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['telefono']:''),
                'max' => 10,
                'title' => 'Número de teléfono',
                'placeholder' => 'Número de teléfono',
                'requerido' => true
            ),
            array(
                'name' => 'cedula_ruc',
                'type' => 'number',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['cedula_ruc']:''),
                'max' => 10,
                'title' => $tipo.', de la persona',
                'placeholder' => $tipo.', de la persona',
                'requerido' => true
            ),
            array(
                'name' => 'estado',
                'title' => 'Estado del atributo',
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
            array(
                'name' => 'direccion',
                'type' => 'textarea',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['direccion']:''),
                'max' => 200,
                'title' => 'Dirección domiciliaria',
                'placeholder' => 'Dirección domiciliaria',
                'requerido' => true
            ),
        );

        return excluirCR($personasLista, $listaExcluir);
    }

    //ENDPOINDS
    public function action($pagina = 'cliente') {
        $this->pagina = $pagina;
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

    public function nombre() {
        $post = (object) $this->request->getGetPost();
        $ins = new Persona();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->nombre_completo), 'nombre_completo')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'nombre_completo'=> strtoupper($post->nombre_completo)
                )
            )));
            exit();
        }
    }

    public function cedula_ruc() {
        $post = (object) $this->request->getGetPost();
        $ins = new Persona();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->cedula_ruc), 'cedula_ruc')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'cedula_ruc'=> strtoupper($post->cedula_ruc)
                )
            )));
            exit();
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Persona();//->getInsertID();
            $estado = $ins->insert($data, false);
            $id = $ins->getInsertID();
            return $estado;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Persona();
            return $ins->update($id, $data);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Persona();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE persona set deleted_at = NULL where idpersona='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE persona set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idpersona='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD($pagina = 'cliente'){
        $this->pagina = $pagina;
        $tipo = '0';
        if($pagina == 'cliente'){
            $tipo = '0';
        }else if($pagina == 'proveedor'){
            $tipo = '1';
        }

        $modelLocal = new Persona();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre_completo ) AS nombre, idpersona as id")
        ->where('tipo', $tipo);//
        // ->where('idusuario', session('usuario')['idusuario']);//

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
        $tipo = '0';
        if($this->pagina == 'cliente'){
            $tipo = '0';
        }else if($this->pagina == 'proveedor'){
            $tipo = '1';
        }

        date_default_timezone_set('America/Guayaquil');
        setlocale(LC_ALL, 'es_ES');
        $fecha = date('Y-m-d', time());
        $hora = date("H:m:s", time());
        $data = array(
            'nombre_completo'   => strtoupper($post->nombre_completo),
            'email'             => strtolower($post->email),
            'telefono'          => strtoupper($post->telefono),
            'direccion'         => ($post->direccion),
            'cedula_ruc'        => strtoupper($post->cedula_ruc),
            'estado'            => strtoupper($post->estado),
            'tipo'              => $tipo,
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
