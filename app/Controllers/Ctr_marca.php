<?php

namespace App\Controllers;
use App\Models\Marca;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_marca extends BaseController{
    public function index(){
        $ins = new Marca();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)[
                "ver" => true
            ],
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de marca',
            'pagina'    =>  'marca',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('marca')),
                    'name' => 'Listado de marcas'
                )
            )
        ];

        if($data["esConsedido"]->ver){
            return view('html/marca/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $table = db_connect()->table('marca');
            $datatable = $table->select('marca.*, CONCAT(empresa.nombre) as empresa');
            $datatable->join('empresa', 'marca.idempresa = empresa.idempresa');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('marca.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idmarca);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('marca.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['all'] , base_url(route_to('marca.editar', $data->idmarca)), $data->idmarca);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idmarca.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i>':'<i class="bi bi-toggle-off fs-4"></i>').'</a>';
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
            'pagina'    =>  'marca.crear',
            'action'    =>  'add',
            'attrform' => $this->atributosForm('crear', 0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('marca')),
                    'name' => 'Listado de marcas'
                ),
                array(
                    'url' => base_url(route_to('marca.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/marca/crear', $data);
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
            'pagina'    =>  'marca.editar',
            'action'    =>  'edit',
            'id'        =>  'idmarca',
            'attrform' => $this->atributosForm('editar', $id),
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('marca')),
                    'name' => 'Listado de marcas'
                )
            )
        ];

        if($data["esConsedido"]->editar){
            return view('html/marca/editar', $data);
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
        $marca = new Marca();
        if($action == 'editar'){
            $data = $marca->find($id);
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
                'title' => 'Estado del marca',
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
            array(
                'name' => 'imagen',
                'type' => 'file',
                'accept' => 'image/*',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['imagen']:''),
                'max' => 1,
                'title' => 'Escribe la imagen de la marca',
                'placeholder' => 'Escribe la imagen de la marca',
                'requerido' => true
            ),
        );

        return excluirCR($atributosLista, $listaExcluir);
    }

    //ENDPOINDS
    public function action() {
        $post = (object) $this->request->getGetPost();
        $data = [];
        if($post->action == 'add' || $post->action == 'edit') $data = $this->editarArray($post, $this->request);
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
        $ins = new Marca();
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
            $ins = new Marca();//->getInsertID();
            $estado = $ins->insert($data, false);
            $id = $ins->getInsertID();
            return $estado;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function edit($id, $data){
        if ($this->request->isAJAX()) {
            $ins = new Marca();
            return $ins->update($id, $data);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Marca();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE marca set deleted_at = NULL where idmarca='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE marca set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idmarca='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Marca();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idmarca");
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

    private function slugify($text, string $divider = '-'){
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    private function uploadImage($post){
        $imageFile = $post->getFile('image_real');

        if ($imageFile && $imageFile->isValid()) {
            // Obtener el tipo MIME real del archivo
            $mimeType = $imageFile->getClientMimeType(); // O getMimeType() si aún no has movido el archivo

            // Tipos de imagen permitidos (excluyendo gif y svg)
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mimeType, $allowedMimeTypes)) {
                return ['resp' => false, 'message' => 'Solo se permiten imágenes JPG, PNG o WEBP'];
            }

            $newName = pathinfo($imageFile->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.png';
            $anio = date('Y');
            $mes = date('m');
            $dia = date('d');
            $uploadPath = './uploads/'.$anio.'/'.$mes.'/'.$dia.'/';

            if ($imageFile->move($uploadPath, $newName)) {
                $imageUrl = 'uploads/'.$anio.'/'.$mes.'/'.$dia.'/'.$newName;
                return ['resp' => true, 'imageUrl' => $imageUrl];
            } else {
                return ['resp' => false, 'message' => 'Error al mover la imagen'];
            }
        }

        return ['resp' => false, 'message' => 'No se proporcionó una imagen válida'];
    }

    private function editarArray($post, $request) {
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
            $image = $this->uploadImage($request);
            if($image['resp']){
                $data['imagen'] = $image['imageUrl'];
            }
            $data['created_at'] = date('Y-m-d H:m:s', time());
        }

        if($post->action == 'edit'){
            $image = $this->uploadImage($request);
            if($image['resp']){
                $data['imagen'] = $image['imageUrl'];
            }
            $data['updated_at'] = date('Y-m-d H:m:s', time());
        }
        return $data;
    }
}
