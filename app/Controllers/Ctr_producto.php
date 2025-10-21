<?php

namespace App\Controllers;
use App\Models\Producto;
use App\Models\Valoratributo;
use App\Models\Atributo;
use App\Models\Detalle_atributo_producto;
use App\Models\Empresa;
use Irsyadulibad\DataTables\DataTables;

class Ctr_producto extends BaseController{
    private $pagina = 'producto';
    public function index(){
        $ins = new Producto();
        $data = [
            'data_accessos' => [],
            'esConsedido'   => (object)esConsedido($this->pagina),
            'registros_no_eliminados'   =>  $ins->countActive(),
            'registros_eliminados'   =>  $ins->countDelete(),
            'titulo'   =>  'Listado de producto',
            'pagina'    =>  $this->pagina,
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('producto')),
                    'name' => 'Listado de productos'
                )
            )
        ];

        if($data["esConsedido"]->leer){
            return view('html/producto/index', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function listar(){
        if ($this->request->isAJAX()) {
            $btn_acciones_list = getDisabledBtnAction($this->pagina);
            $table = db_connect()->table('producto');
            $datatable = $table->select('producto.*, 
            CONCAT(empresa.nombre) as empresa, 
            CONCAT(categoria.nombre) as categoria, 
            ( select sum(detalle_compra.venta_usado_cantidad) from detalle_compra where detalle_compra.idproducto = producto.idproducto ) as stock_actual');
            $datatable->join('empresa', 'producto.idempresa = empresa.idempresa');
            $datatable->join('categoria', 'categoria.idcategoria = producto.idcategoria');

            if($this->request->getGetPost()['eliminado'] == '1'){
                $datatable->where('producto.deleted_at <>' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) {
                        return btn_acciones(['restore'] , '', $data->idproducto);
                    })
                    ->rawColumns(['accion'])
                    ->make(false);
            }else{
                $datatable->where('producto.deleted_at' , null);
                return datatables($datatable)
                    ->addColumn('accion', function($data) use ($btn_acciones_list) {
                        return btn_acciones($btn_acciones_list , base_url(route_to('producto.editar', $data->idproducto)), $data->idproducto);
                    })
                    ->editColumn('estado', function($value, $data) {
                        return '<a title="Cambiar estado" class="d-flex align-items-center gap-2 btn btn-link btn-sm text-'.($value=='1'?'success':'warning').'" data-action="estado" data-estado="'.$value.'" data-id="'.$data->idproducto.'" href="#">'.($value=='1'?'<i class="bi bi-toggle-on fs-4"></i> <small class="text-muted">Activo</small>':'<i class="bi bi-toggle-off fs-4"></i> <small class="text-muted">Inactivo</small>').'</a>';
                    })
                    ->editColumn('imagen', function($value, $data) {
                        return '<a href="'.base_url($value).'" data-lightbox="'.$data->idproducto.'" data-title="'.$data->nombre.'"><img src="'.base_url($value).'" alt="'.$data->nombre.'" width="50" height="50"></a>';
                    })
                    ->editColumn('descripcion', function($value, $data) {
                        return '<div class="position-relative">'.$value.'</div>';
                    })
                    ->rawColumns(['accion', 'estado', 'imagen','descripcion'])
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
            'titulo'   =>  'Crear producto',
            'pagina'    =>  $this->pagina,
            'action'    =>  'add',
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('producto')),
                    'name' => 'Listado de productos'
                ),
                array(
                    'url' => base_url(route_to('producto.crear')),
                    'name' => 'Crear registro'
                )
            )
        ];

        if($data["esConsedido"]->crear){
            return view('html/producto/crear', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    public function editar($id){
        $producto = $this->getProducto($id);
        $atributoProducto = new Detalle_atributo_producto();
        $atributoProducto->select('detalle_atributo_producto.*, valoratributo.nombre as valoratributo_nombre, atributo.idatributo, atributo.nombre as atributo_nombre');
        $atributoProducto->join('valoratributo', 'detalle_atributo_producto.idvaloratributo = valoratributo.idvaloratributo');
        $atributoProducto->join('atributo', 'atributo.idatributo = valoratributo.idatributo');
        $atributoProducto->where('detalle_atributo_producto.idproducto', $id);
        $resultadosAtributoProducto = $atributoProducto->where('detalle_atributo_producto.estado', 1)->findAll();

        $data = [
            'data_accessos' => [],
            'producto' => $producto,
            'atributoProducto' => $resultadosAtributoProducto,
            'esConsedido'   => (object)esConsedido($this->pagina),
            'titulo'   =>  'Editar registro',
            'pagina'    =>  $this->pagina,
            'action'    =>  'edit',
            'id'        =>  'idproducto',
            'idValue'   =>  $id,
            'breadcrumb' => array(
                array(
                    'url' => base_url(route_to('inicio')),
                    'name' => 'Inicio'
                ),
                array(
                    'url' => base_url(route_to('producto')),
                    'name' => 'Listado de productos'
                )
            )
        ];

        if($data["esConsedido"]->modificar){
            return view('html/producto/editar', $data);
        }

        return $this->response->setJSON([
            "resp" => false,
            "message" => "No tienes acceso"
        ]);
    }

    private function getProducto($id){
        $ins = new Producto();
        $data = $ins
        ->select("producto.*, categoria.nombre as categoria_nombre, empresa.nombre as empresa_nombre")
        ->join('categoria', 'producto.idcategoria = categoria.idcategoria')
        ->join('empresa', 'producto.idempresa = empresa.idempresa')
        ->first();
        if($data){
            return $data;
        }
        return null;
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
                $data['atributos'] = json_decode($post->atributos);
                return $this->response->setJSON( [
                    "resp" => $this->add($data)
                ] );
                break;
            case 'edit':
                $data['atributos'] = json_decode($post->atributos);
                return $this->response->setJSON( [
                    "resp" => $this->edit($post->id, $data, $post)
                ] );
                break;

            default:
                $this->response->setStatusCode(404, 'Error con la petición');
                break;
        }
    }

    public function nombre() {
        $post = (object) $this->request->getGetPost();
        $ins = new Producto();
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

    public function codigo_barras() {
        $post = (object) $this->request->getGetPost();
        $ins = new Producto();
        if ($post->id == '0') {
            echo json_encode(array('valid' => !$ins->existe($ins->table, strtoupper($post->codigo_barras), 'codigo_barras')));
            exit();
        } else {
            echo json_encode(array('valid' => !$ins->existe_editar(
                $ins->table,
                $ins->primaryKey,
                $post->id,
                array(
                    'codigo_barras'=> strtoupper($post->codigo_barras)
                )
            )));
            exit();
        }
    }

    private function addValoratributo($atributo, $idatributo){
        $id = "";
        if (isset($atributo->isNew) && $atributo->isNew) {
            $ins_valoratributo = new Valoratributo();
            $estado = $ins_valoratributo->insert([
                'nombre' => strtoupper($atributo->text),
                'idatributo' => $idatributo
            ], false);
            $id = $ins_valoratributo->getInsertID();
            return $id;
        }
        return $atributo->id;
    }

    private function addAtributo($atributo){
        $idAtributo = "";
        $ins_atributo = new Atributo();
        if(isset($atributo->isNew) && $atributo->isNew){
            $estado = $ins_atributo->insert([
                'nombre' => strtoupper($atributo->nombre),
                'estado' => 1
            ], false);
            $idAtributo = $ins_atributo->getInsertID();
            return $idAtributo;
        }else{
            return $atributo->id;
        }
    }

    private function add($data){
        if ($this->request->isAJAX() && !isset($data['resp'])) {
            $ins = new Producto();//->getInsertID();
            $ins->insert($data, false);
            $idProducto = $ins->getInsertID();
            $ins->update($idProducto, ['slug' => $data["slug"]."-".$idProducto]);

            foreach ($data['atributos'] as $atributo) {
                $idAtributo = $this->addAtributo($atributo);

                foreach ($atributo->data->nombre as $valor) {
                    $idValoratributo = $this->addValoratributo($valor, $idAtributo);
                    $ins_Detalle_atributo_producto = new Detalle_atributo_producto();
                    $ins_Detalle_atributo_producto->insert([
                        'idproducto' => $idProducto,
                        'estado' => 1,
                        'precio_pvp' => 0,
                        'idvaloratributo' => $idValoratributo
                    ], false);
                }

            }
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function clearAtributoProducto($idproducto){
        $ins_Detalle_atributo_producto = new Detalle_atributo_producto();
        $ins_Detalle_atributo_producto->where('idproducto', $idproducto)->delete();
        return true;
    }

    private function edit($id, $data, $post){
        if ($this->request->isAJAX()) {
            $ins = new Producto();
            // $data["slug"] = $data["slug"]."-".$id;
            $ins->update($id, $data);
            $idProducto = $id;

            if($post->editarAtributo == "true"){
                $this->clearAtributoProducto($idProducto);
                foreach ($data['atributos'] as $atributo) {
                    $idAtributo = $this->addAtributo($atributo);

                    foreach ($atributo->data->nombre as $valor) {
                        $idValoratributo = $this->addValoratributo($valor, $idAtributo);
                        $ins_Detalle_atributo_producto = new Detalle_atributo_producto();

                        $existeAtributoProducto = $ins_Detalle_atributo_producto
                            ->where('idproducto', $idProducto)
                            ->where('idvaloratributo', $idValoratributo)
                            ->first();

                        if(!$existeAtributoProducto){
                            $ins_Detalle_atributo_producto->insert([
                                'idproducto' => $idProducto,
                                'estado' => 1,
                                'precio_pvp' => 0,
                                'idvaloratributo' => $idValoratributo
                            ], false);
                        }
                    }

                }
            }
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function delete($id){
        if ($this->request->isAJAX()) {
            $ins = new Producto();
            return $ins->delete($id);
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function restore($id){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE producto set deleted_at = NULL where idproducto='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    private function estado($id, $data){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->query('UPDATE producto set updated_at="'.date('Y-m-d H:i:s', time()).'", estado = "'.($data->estado=='1'?'0':'1').'" where idproducto='.$id);
            return true;
        }else{
            $this->response->setStatusCode(404, 'Error con la petición');
        }
    }

    public function selectBD(){
        $modelLocal = new Producto();
        $request = service('request');
        $post = $request->getPost();
        
        // Validación de parámetros
        $page = (int)($post['page'] ?? 1);
        $size = (int)($post['size'] ?? 10);
        $searchTerm = $post['searchTerm'] ?? null;

        // Construcción segura de la consulta
        $builder = $modelLocal->builder();
        
        $builder->select("CONCAT( nombre ) AS nombre, idproducto, imagen")
        ->where('estado', 1)
        ->where('deleted_at', null);

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

    //Menos es mas compresion
    private function makeWhiteTransparent($pathToImage, $outputPath, $quality = 80, $format = 'png') {
        // Detectar tipo de imagen original
        $info = getimagesize($pathToImage);
        $mime = $info['mime'];
    
        // Crear imagen desde archivo según el MIME
        switch ($mime) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($pathToImage);
                break;
            case 'image/png':
                $img = imagecreatefrompng($pathToImage);
                break;
            case 'image/webp':
                $img = imagecreatefromwebp($pathToImage);
                break;
            default:
                throw new \Exception('Formato de imagen no soportado');
        }
    
        $width = imagesx($img);
        $height = imagesy($img);
    
        $output = imagecreatetruecolor($width, $height);
        imagealphablending($output, false);
        imagesavealpha($output, true);
        $trans_colour = imagecolorallocatealpha($output, 0, 0, 0, 127);
        imagefill($output, 0, 0, $trans_colour);
    
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgba = imagecolorat($img, $x, $y);
                $alpha = ($rgba & 0x7F000000) >> 24;
    
                $r = ($rgba >> 16) & 0xFF;
                $g = ($rgba >> 8) & 0xFF;
                $b = $rgba & 0xFF;
    
                // Mantener transparencia original (si no es JPEG)
                if ($mime !== 'image/jpeg' && $alpha > 0) {
                    $preserved = imagecolorallocatealpha($output, $r, $g, $b, $alpha);
                    imagesetpixel($output, $x, $y, $preserved);
                    continue;
                }
    
                // Convertir blancos a transparente
                if ($r > 240 && $g > 240 && $b > 240) {
                    imagesetpixel($output, $x, $y, $trans_colour);
                } else {
                    $color = imagecolorallocatealpha($output, $r, $g, $b, 0);
                    imagesetpixel($output, $x, $y, $color);
                }
            }
        }
    
        // Guardar imagen optimizada según el formato
        switch (strtolower($format)) {
            case 'webp':
                imagewebp($output, $outputPath, $quality); // calidad de 0 a 100
                break;
            case 'png':
            default:
                // PNG usa compresión inversa: 0 (sin compresión) a 9 (máxima)
                $pngCompression = (int)((100 - $quality) / 10);
                imagepng($output, $outputPath, $pngCompression);
                break;
        }
    
        imagedestroy($img);
        imagedestroy($output);

        // Delete original image after creating transparent version
        if (file_exists($pathToImage)) {
            unlink($pathToImage);
        }
        return true;
    }
       

    private function uploadImage($post){
        $imageFile = $post->getFile('image_real');

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
                $finalPathTrans = $uploadPath . "trans_" . $newName;
                $finalURLTrans = 'uploads/' . $folder . "trans_" . $newName;

                // Aplicar transparencia después de moverlo
                $this->makeWhiteTransparent($finalPath, $finalPathTrans);

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
            'idempresa' => 1,
            'idcategoria' => strtoupper($post->idcategoria),
            'nombre' => strtoupper($post->nombre),
            'codigo_barras' => strtoupper($post->codigo_barras),
            'descripcion'   => $post->descripcion,
            'precio_venta'  => $post->precio_venta,
            'stock'         => $post->stock,
            'stock_minimo'  => $post->stock_minimo,
            'estado'        => $post->estado,
            'slug'          => $post->nombre,
        );
        if($post->action == 'add'){
            $data['slug'] = $this->slugify($post->nombre);
            $image = $this->uploadImage($request);
            if($image['resp']){
                $data['imagen'] = $image['imageUrl'];
            }else{
                return ["resp" => false, "message" => "Error al subir la imagen"];
            }
            $data['stock'] = 0;
            $data['created_at'] = date('Y-m-d H:m:s', time());
        }
        if($post->action == 'edit'){
            $data['slug'] = $this->slugify($post->nombre);
            if($post->editarImagen == "true"){
                $image = $this->uploadImage($request);
                if($image['resp']){
                    $data['imagen'] = $image['imageUrl'];
                }else{
                    return ["resp" => false, "message" => "Error al subir la imagen"];
                }
            }
            $data['updated_at'] = date('Y-m-d H:m:s', time());
        }

        return $data;
    }
}
