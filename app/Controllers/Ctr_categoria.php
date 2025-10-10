<?php

namespace App\Controllers;
use App\Models\Categoria;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_categoria extends BaseController{
    public function index(){
        $ins = new Categoria();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "ver" => true
            ],
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de categoria',
            'pagina'    =>  'categoria',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('categoria')),
                    'name' => 'Listado de categorias'
                )
            )
        ];

        if($data["esConsedido"]->ver){
            return view('html/categoria/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $table = db_connect()->table('categoria');
            $datatable = $table->select('categoria.*, CONCAT(empresa.nombre) as empresa');
            $datatable->join('empresa', 'categoria.idempresa = empresa.idempresa');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('categoria.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idcategoria);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('categoria.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['all'] , base_url(route_to('categoria.editar', $data->idcategoria)), $data->idcategoria);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idcategoria.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
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
            'pagina'    =>  'categoria.crear',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('categoria')),
                    'name' => 'Listado de categorias'
                ),
                array(
                    'url' => base_url(route_to('categoria.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/categoria/crear', $data);
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
            'pagina'    =>  'categoria.editar',
            'action'    =>  'edit',
            'id'        =>  'idcategoria',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('categoria')),
                    'name' => 'Listado de categorias'
                )
            )
        ];

        if($data["esConsedido"]->editar){
            return view('html/categoria/editar', $data);
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
        $categoria = new Categoria();
        if($action == 'editar'){
            $data = $categoria->find($id);
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
                'name' => 'idempresa',
                'url' => base_url(route_to('empresa')),
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
                'name' => 'estado',
                'title' => 'Estado del categoria',
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

    public function nombre() {
        $post = (object) $this->request->getGetPost();
        $ins = new Categoria();
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

    private function add($data){
        if ($this->request->isAJAX()) {
            $ins = new Categoria();//->getInsertID();
            $estado = $ins->insert($data, false);
            $id = $ins->getInsertID();
            return $estado;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Categoria();
            return $ins->update($id, $data);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Categoria();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE categoria set deleted_at = NULL where idcategoria='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE categoria set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idcategoria='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Categoria();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idcategoria");
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
