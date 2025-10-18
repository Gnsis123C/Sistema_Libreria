<?php
use Config\Database;

function esConsedido($pagina = "") {
	$idusuario = session('usuario')["idusuario"];
	if($idusuario == 1) return array(
		'modulo'	=> "all",
		'crear'		=>'1',
		'leer'		=>'1',
		'modificar'	=>'1',
		'eliminar'	=>'1',
	);

	$db = Database::connect();
	$builder = $db->table('detalle_rol');
	$builder->select('detalle_rol.*');
	$builder->join('usuario','usuario.idrol=detalle_rol.idrol');
	$builder->join('pagina','pagina.idpagina=detalle_rol.idpagina');
	$builder->where('usuario.idusuario', $idusuario);
	$builder->where('pagina.nombre', $pagina);
	$query = $builder->get();
	if($query->getNumRows() < 1) return array(
		'modulo'	=> "none",
		'crear'		=>'0',
		'leer'		=>'0',
		'modificar'	=>'0',
		'eliminar'	=>'0',
	);

	$data = $query->getRow() ?? [];
    // We need to use $CI->session instead of $this->session
    return array(
		'modulo'	=> $pagina,
		'crear'		=> $data->crear,
		'leer'		=> $data->leer,
		'modificar'	=> $data->editar,
		'eliminar'	=> $data->eliminar,
	);
}

function getMenu($pagina = '') {
	$idusuario = session('usuario')["idusuario"];
	$acceso_menu = ['inicio', 'empresa', 'usuario','categoria','rol','atributo','cliente','proveedor','producto'];
	if($idusuario != 1) {
		$db = Database::connect();
		$builder = $db->table('detalle_rol');
		$builder->select('pagina.nombre');
		$builder->join('usuario','usuario.idrol=detalle_rol.idrol');
		$builder->join('pagina','pagina.idpagina=detalle_rol.idpagina');
		$builder->where('usuario.idusuario', $idusuario);
		$builder->where('detalle_rol.leer', 1);
		$query = $builder->get();
		if($query->getNumRows() < 1) return array(
			'modulo'	=> "none",
			'crear'		=>'0',
			'leer'		=>'0',
			'modificar'	=>'0',
			'eliminar'	=>'0',
		);

		$data = $query->getResult('array') ?? [];

		$acceso_menu = array_map(function($item) {
			return strtolower($item['nombre']);
		}, $data);
		$acceso_menu[] = 'inicio'; // Asegurar que 'inicio' siempre esté presente
	}

	$menu = [
		[
			'tipo' => '',
			'tipo_text' => '',
			'data' => [
				[
					'titulo' 	=> 'Inicio',
					'link' 		=> base_url(route_to('inicio')),
					'icon' 		=> 'home-2',
					'active' 	=> false,
					'pagina' 	=> 'inicio',
				]
			]
		],
		[
			'tipo' => '',
			'tipo_text' => '',
			'data' => [
				[
					'titulo' => 'Empresa',
					'link' => base_url(route_to('empresa')),
					'icon' => 'buildings-1',
					'active' 	=> false,
					'pagina' 	=> 'empresa',
				]
			]
		],
		[
			'tipo' => '',
			'tipo_text' => '',
			'data' => [
				[
					'titulo' => 'Usuarios',
					'link' => base_url(route_to('usuario')),
					'icon' => 'user-multiple-4',
					'active' 	=> false,
					'pagina' 	=> 'usuario',
				]
			]
		],
		[
			'tipo' => '',
			'tipo_text' => '',
			'data' => [
				[
					'titulo' => 'Roles y accesos',
					'link' => base_url(route_to('rol')),
					'icon' => 'gear-1',
					'active' 	=> false,
					'pagina' 	=> 'rol',
				]
			]
		],
		[
			'tipo' => 'header',
			'tipo_text' => 'Admin. Ventas',
			'tipo_text_title' => 'Administración de ventas',
			'data' => [
				[
					'titulo' => 'Clientes',
					'link' => base_url(route_to('persona','cliente')),
					'icon' => 'user-multiple-4',
					'active' 	=> false,
					'pagina' 	=> 'cliente',
				]
			]
		],
		[
			'tipo' => 'header',
			'tipo_text' => 'Admin. Compras',
			'tipo_text_title' => 'Administración de compras',
			'data' => [
				[
					'titulo' => 'Proveedores',
					'link' => base_url(route_to('persona','proveedor')),
					'icon' => 'user-multiple-4',
					'active' 	=> false,
					'pagina' 	=> 'proveedor',
				]
			]
		],
		[
			'tipo' => 'header',
			'tipo_text' => 'Admin. Productos',
			'tipo_text_title' => 'Administración de productos',
			'data' => [
				[
					'titulo' => 'Categoría',
					'link' => base_url(route_to('categoria')),
					'icon' => 'brush-1-rotated',
					'active' 	=> false,
					'pagina' 	=> 'categoria',
				],
				[
					'titulo' => 'Atributos',
					'link' => base_url(route_to('atributo')),
					'icon' => 'brush-1-rotated',
					'active' 	=> false,
					'pagina' 	=> 'atributo',
				],
				[
					'titulo' => 'Productos',
					'link' => base_url(route_to('producto')),
					'icon' => 'layers-1',
					'active' 	=> false,
					'pagina' 	=> 'producto',
				],
			]
		]
	];

	$menu_filtrado = [];

    foreach ($menu as $bloque) {
        $data_filtrada = [];

        foreach ($bloque['data'] as $item) {
            // ✅ Marcar activo si coincide la página
            if ($item['pagina'] === $pagina) {
                $item['active'] = true;
            }

            // ✅ Filtrar por acceso_menu (si se pasó)
            if (empty($acceso_menu) || in_array($item['pagina'], $acceso_menu)) {
                $data_filtrada[] = $item;
            }
        }

        // ✅ Solo agregar bloques que aún tengan data
        if (!empty($data_filtrada)) {
            $bloque['data'] = $data_filtrada;
            $menu_filtrado[] = $bloque;
        }
    }

    return $menu_filtrado;
}

function getDisabledBtnAction($opcion_menu = ""){
	$permisos = esConsedido($opcion_menu);
	$accesos = [];
	$countAcceso = 0;
	if($permisos['modificar'] == '1'){
		$accesos[] = 'editar';
		$countAcceso++;
	}

	if($permisos['eliminar'] == '1'){
		$accesos[] = 'elim';
		$countAcceso++;
	}

	return $countAcceso == 2 ? ['all'] : $accesos;
}
	
if (!function_exists('excluirCR')) {
    function excluirCR($data, $excluir) {
        // Validar que $data sea un array
        if (!is_array($data)) {
            return $data;
        }
        
        // Validar que $excluir sea un array
        if (!is_array($excluir)) {
            return $data;
        }
        
        // Si alguno de los arrays está vacío, retornar el original
        if (empty($data) || empty($excluir)) {
            return $data;
        }
        
        // Recorrer de atrás hacia adelante para evitar problemas con índices al eliminar
        for ($i = count($data) - 1; $i >= 0; $i--) {
            // Verificar que el elemento tenga la clave 'name'
            if (!isset($data[$i]['name'])) {
                continue;
            }
            
            // Verificar si el nombre está en la lista de exclusión
            if (in_array($data[$i]['name'], $excluir, true)) {
                array_splice($data, $i, 1);
            }
        }
        
        return $data;
    }
}

if ( ! function_exists('slugify_()')){
	function slugify_($text, string $divider = '-'){
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
}


if ( ! function_exists('list_estado_acceso_sistema()')){
	function list_estado_acceso_sistema($id = ''){
		$data = [
			['id' => '1', 'text' => 'Permitido'],
			['id' => '0', 'text' => 'Denegado']
		];

		try {
			if($id != ''){
				foreach ($data as $d) {
					if($d['id'] == $id){
						return $d;
					}
				}
				return $data[0];
			}
			return $data;
		} catch (\Throwable $th) {
			return [];
		}
	}
}

if ( ! function_exists('btn_acciones()')){
	function btn_acciones($accionesList = ['all'], $url = '', $id = 0, $disabled = '', $custom_btn = []){
		$acciones = '';
		$num = 0;
		$restore = false;
		$elim = false;
		$editar = false;

		$restoreBtn = '';
		$elimBtn = '';
		$editarBtn = '';
		$info = '';

		if($disabled == 'disabled'){
			$restoreBtn = '<li><a class="dropdown-item disabled" href="#"> <i class="bi bi-arrow-counterclockwise"></i> Recuperar</a></li>';
			$elimBtn = '<li><a class="dropdown-item disabled" href="#"> <i class="bi bi-trash"></i> Eliminar</a></li>';
			$editarBtn = '<li><a class="dropdown-item disabled" href="#"> <i class="bi bi-pencil"></i> Editar</a></li>';
			$info = '<li><hr class="dropdown-divider"></li><li><h6 class="dropdown-header fw-light"><i class="bi bi-info-circle"></i> No se puede editar</h6></li>';
		}else{
			$restoreBtn = '<li><a class="dropdown-item" data-action="restore" data-id="'.$id.'" href="#"> <i class="bi bi-arrow-counterclockwise"></i> Recuperar</a></li>';
			$elimBtn = '<li><a class="dropdown-item" data-action="elim" data-id="'.$id.'" href="#"> <i class="bi bi-trash"></i> Eliminar</a></li>';
			$editarBtn = '<li><a class="dropdown-item" href="'.$url.'"> <i class="bi bi-pencil"></i> Editar</a></li>';
		}

		if (in_array("restore", $accionesList)) {
			$restore = true;
			$acciones .= $restoreBtn;
			$num++;
		}

		if (in_array("all", $accionesList)) {
			$elim = true;
			$editar = true;

			$acciones .= $editarBtn;
        	$acciones .= $elimBtn;
			$num++;
		}

		if(!in_array("all", $accionesList)){
			if(in_array("editar", $accionesList)){
				$editar = true;
				$acciones .= $editarBtn;
				$num++;
			}
			if(in_array("elim", $accionesList)){
				$elim = true;
				$acciones .= $elimBtn;
				$num++;
			}
		}

		// Handle custom buttons if provided
		if (count($custom_btn) > 0) {
			$acciones .= '<li><hr class="dropdown-divider"></li>';
			foreach ($custom_btn as $btn) {
				if (isset($btn['name']) && isset($btn['value']) && isset($btn['icon'])) {
					$acciones .= '<li><a class="dropdown-item" href="#" data-action="'.$btn['name'].'" data-id="'.$btn['value'].'">
						<i class="'.$btn['icon'].'"></i> '.$btn['text'].'</a></li>';
					$num++;
				}
			}
		}

		$html = '<div class="dropdown">
			<button data-id="dropdown_accion_'.$id.'" class="btn btn-success dropdown-toggle rounded-0" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
				Acciones
			</button>
			<ul class="dropdown-menu dropdown-menu-lg-end rounded-0">
				<li><h6 class="dropdown-header">Opciones</h6></li>
				<li><hr class="dropdown-divider"></li>
				'.$acciones.'
				'.$info.'
			</ul>
		</div>';

        return $html;
	}
}

if ( ! function_exists('list_tipo_usuario()')){
	function list_tipo_usuario($id = ''){
		$data = [
			['id' => '1', 'text' => 'Administrador', 'color' => 'secondary'],
			['id' => '2', 'text' => 'Técnico', 'color' => 'primary'],
			['id' => '3', 'text' => 'Operario', 'color' => 'success']
		];

		try {
			if($id != ''){
				foreach ($data as $d) {
					if($d['id'] == $id){
						return $d;
					}
				}
				return ['id' => '0', 'text' => 'Otro', 'color' => 'dark'];
			}
			return $data;
		} catch (\Throwable $th) {
			return [];
		}
	}
}