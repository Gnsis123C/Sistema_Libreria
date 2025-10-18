<?php

namespace App\Controllers;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_empresa extends BaseController{
    private $pagina = 'usuario';

    public function index(){
        $id = session('empresa')["idempresa"];
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   =>  'Editar registro',
            'pagina'    =>  'empresa',
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

        if($data["esConsedido"]->modificar){
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
                'name' => 'change_logo',
                'type' => 'hidden',
                'value' => '01',
                'max' => 2,
                'title' => '',
                'requerido' => true
            ),
            array(
                'name' => 'id',
                'type' => 'hidden',
                'value' => ($action == 'editar'?$id:''),
                'max' => 100,
                'title' => '',
                'requerido' => true
            ),
            // array(
            //     'name' => 'logo',
            //     'type' => 'hidden',
            //     'value' => "logo-cr-svg-blanco.svg?v=1",
            //     'max' => 100,
            //     'title' => '',
            //     'requerido' => true
            // ),
            array(
                'name' => 'nombre',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'? $data['nombre']:''),
                'max' => 100,
                'title' => 'Nombre de la empresa',
                'placeholder' => 'Nombre de la empresa',
                'requerido' => true
            ),
            array(
                'name' => 'direccion',
                'type' => 'textAndNumber',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'?$data['direccion']:''),
                'max' => 100,
                'title' => 'Dirección de la empresa',
                'placeholder' => 'Dirección',
                'requerido' => true
            ),
            array(
                'name' => 'ruc',
                'type' => 'number',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'?$data['ruc']:''),
                'max' => 13,
                'title' => 'RUC de la empresa',
                'placeholder' => 'RUC',
                'requerido' => true
            ),
            array(
                'name' => 'logo',
                'type' => 'file',
                'column' => 'col-md-12',
                'value' => ($action == 'editar'?$data['logo']:''),
                'max' => 100,
                'title' => 'Logo de la empresa',
                'placeholder' => 'Logo',
                'accept' => 'image/*',
                'max_files' => 1,
                'multiple' => false,
                'requerido' => true
            ),
            // array(
            //     'name' => 'estado',
            //     'title' => 'Estado del empresa',
            //     'requerido' => true,
            //     'type' => 'select', //num
            //     'option' => array(
            //         array(
            //             'value' => '1',
            //             'text' => 'Activo',
            //             'selected' => ($action == 'editar'?($data['estado']=='1'?true:false):''),
            //             'attr' => array(
            //                 'text' => 's',
            //                 'value' => '3'
            //             )
            //         ),
            //         array(
            //             'value' => '0',
            //             'text' => 'Inactivo',
            //             'selected' => ($action == 'editar'?($data['estado']=='0'?true:false):''),
            //             'attr' => array(
            //                 'text' => '3',
            //                 'value' => '3'
            //             )
            //         )
            //     )
            // ),
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
                // return $this->listar();
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
            $session = session();
            $ins = new Empresa();
            $ins->update($id, $data);
            $empresa = $ins->where('idempresa',strtolower($session->empresa['idempresa']))->first();
            $session->set('empresa', $empresa);
            return true;
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
        
        $builder->select("CONCAT(nombre) AS nombre, idempresa as id, logo")
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
        $imageFile = $post->getFile('logo');

        if ($imageFile && $imageFile->isValid()) {
            $mimeType = $imageFile->getClientMimeType();
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mimeType, $allowedMimeTypes)) {
                return ['resp' => false, 'message' => 'Solo se permiten imágenes JPG, PNG o WEBP'];
            }

            $newName = pathinfo($imageFile->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.png';
            $anio = date('Y');
            $mes = date('m');
            $dia = date('d');
            $folder = $anio . '/' . $mes . '/' . $dia . '/';
            $uploadPath = './uploads/' . $folder;

            // Asegúrate de que el directorio exista
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $finalPath = $uploadPath . $newName;
            // Mover primero el archivo
            if ($imageFile->move($uploadPath, $newName)) {
                $finalURLTrans = 'uploads/' . $folder . $newName;
                return ['resp' => true, 'imageUrl' => $finalURLTrans];
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
            'nombre'    => ($post->nombre),
            'direccion' => ($post->direccion),
            'ruc' => ($post->ruc),
            // 'logo'      => strtolower($post->logo),
            'estado'    => 1
        );

        if($post->change_logo == '1'){
            $image = $this->uploadImage($request);
            if($image['resp']){
                $data['logo'] = $image['imageUrl'];
            }else{
                return ["resp" => false, "message" => "Error al subir la imagen"];
            }
        }

        if($post->action == 'add'){
            $data['created_at'] = date('Y-m-d H:m:s', time());
        }
        if($post->action == 'edit'){
            $data['updated_at'] = date('Y-m-d H:m:s', time());
        }
        return $data;
    }
}
