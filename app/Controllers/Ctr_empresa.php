<?php

namespace App\Controllers;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_empresa extends BaseController{
    public function index(){
        $ins = new Empresa();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "ver" => true
            ],
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de empresas',
            'pagina'    =>  'empresa',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('empresa')),
                    'name' => 'Listado de empresas'
                )
            )
        ];

        if($data["esConsedido"]->ver){
            return view('html/empresa/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $table = db_connect()->table('empresa');
            $datatable = $table->select('empresa.*');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('empresa.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idempresa);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('empresa.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['all'] , base_url(route_to('empresa.editar', $data->idempresa)), $data->idempresa);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idempresa.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
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
            'titulo'   =>  'Crear registro',
            'pagina'    =>  'empresa.crear',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('empresa')),
                    'name' => 'Listado de empresas'
                ),
                array(
                    'url' => base_url(route_to('empresa.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/empresa/crear', $data);
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
            'pagina'    =>  'empresa.editar',
            'action'    =>  'edit',
            'id'        =>  'idempresa',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('empresa')),
                    'name' => 'Listado de empresas'
                )
            )
        ];

        if($data["esConsedido"]->editar){
            return view('html/empresa/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function atributosForm($action, $id){
        $data = array();
        $listaExcluir = [];
        $empresa = new Empresa();
        if($action == 'editar'){
            $data = $empresa->find($id);
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
                'title' => 'Escribe sus nombre',
                'placeholder' => 'Escribe sus nombre',
                'requerido' => true
            ),
            array(
                'name' => 'direccion',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'?$data['direccion']:''),
                'max' => 100,
                'title' => 'Dirección',
                'placeholder' => 'Dirección',
                'requerido' => true
            ),
            // array(
            //     'name' => 'logo',
            //     'type' => 'file',
            //     'column' => 'col-md-12',
            //     'value' => ($action == 'editar'?$data['logo']:''),
            //     'max' => 100,
            //     'title' => 'Logo',
            //     'placeholder' => 'Logo',
            //     'accept' => 'image/*',
            //     'max_files' => 1,
            //     'multiple' => false,
            //     'requerido' => true
            // ),
            array(
                'name' => 'estado',
                'title' => 'Estado del empresa',
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

    public function correo() {
        $post = (object) $this->request->getGetPost();
        $ins = new Empresa();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->correo), 'correo')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'correo'=> strtoupper($post->correo)
                )
            )));
            exit();
        }
    }

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Empresa();//->getInsertID();
            $estado = $ins->insert($data, false);
            $id = $ins->getInsertID();
            return $estado;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Empresa();
            return $ins->update($id, $data);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Empresa();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE empresa set deleted_at = NULL where idempresa='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE empresa set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idempresa='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD() {
        $modelLocal = new Empresa();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;
    
        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT(nombre) AS nombre, idempresa, logo")
                ->where('deleted_at', null);  // <- Aquí el filtro de soft delete
    
        if (!empty($searchTerm)) {
            $builder->groupStart()
                ->like("CONCAT(nombre)", $searchTerm)
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
            'nombre'    => strtoupper($post->nombre),
            'direccion' => strtoupper($post->direccion),
            'logo'      => strtolower($post->logo),
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
