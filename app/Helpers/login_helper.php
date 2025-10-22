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
	$acceso_menu = ['inicio', 'empresa', 'usuario','categoria','rol','atributo','cliente','proveedor','producto','compra', 'venta'];
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
					'titulo' => 'Ventas',
					'link' => base_url(route_to('venta')),
					'icon' => 'cart-1',
					'active' 	=> false,
					'pagina' 	=> 'venta',
				],
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
					'titulo' => 'Compras',
					'link' => base_url(route_to('compra')),
					'icon' => 'cart-1',
					'active' 	=> false,
					'pagina' 	=> 'compra',
				],
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
					'titulo' => 'Productos',
					'link' => base_url(route_to('producto')),
					'icon' => 'box-closed',
					'active' 	=> false,
					'pagina' 	=> 'producto',
				],
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

function obtenerTemporadaEcuador($fecha = null) {
    // Si no se proporciona fecha, usar la actual
    $fecha = $fecha ? DateTime::createFromFormat('Y-m-d', $fecha) : new DateTime();
    $fechaStr = $fecha->format('Y-m-d');
    $anio = (int)$fecha->format('Y');
    
    // Array con todas las temporadas y festivos de Ecuador CON RANGOS
    $temporadas = [
        // NAVIDAD - Rango amplio (todo diciembre + primera semana de enero)
        [
            'id' => 'navidad',
            'title' => 'Navidad y Fin de Año',
            'fecha' => $anio . '-12-01/' . ($anio + 1) . '-01-07',
            'tipo' => 'festividad',
            'prioridad' => 10
        ],
        
        // AÑO NUEVO - Rango específico
        [
            'id' => 'ano_nuevo',
            'title' => 'Año Nuevo',
            'fecha' => $anio . '-12-28/' . ($anio + 1) . '-01-03',
            'tipo' => 'festivo',
            'prioridad' => 9
        ],
        
        // CARNAVAL - Rango extendido (semana antes y después)
        [
            'id' => 'carnaval',
            'title' => 'Carnaval',
            'fecha' => calcularRangoFestivo(calcularCarnaval($anio), 4, 2),
            'tipo' => 'festivo',
            'prioridad' => 8
        ],
        
        // SEMANA SANTA - Rango extendido
        [
            'id' => 'semana_santa',
            'title' => 'Semana Santa',
            'fecha' => calcularRangoFestivo(calcularViernesSanto($anio), 3, 3),
            'tipo' => 'festivo',
            'prioridad' => 8
        ],
        
        // DÍA DE LOS DIFUNTOS - Rango extendido
        [
            'id' => 'dia_difuntos',
            'title' => 'Día de los Difuntos',
            'fecha' => calcularRangoFestivo($anio . '-11-02', 2, 2),
            'tipo' => 'festivo',
            'prioridad' => 7
        ],
        
        // MES DE LA PATRIA - Agosto completo
        [
            'id' => 'mes_patria',
            'title' => 'Mes de la Patria',
            'fecha' => $anio . '-08-01/' . $anio . '-08-31',
            'tipo' => 'temporada',
            'prioridad' => 6
        ],
        
        // INDEPENDENCIA DE GUAYAQUIL - Rango extendido
        [
            'id' => 'independencia_guayaquil',
            'title' => 'Independencia de Guayaquil',
            'fecha' => calcularRangoFestivo($anio . '-10-09', 3, 3),
            'tipo' => 'festivo',
            'prioridad' => 7
        ],
        
        // INDEPENDENCIA DE CUENCA - Rango extendido
        [
            'id' => 'independencia_cuenca',
            'title' => 'Independencia de Cuenca',
            'fecha' => calcularRangoFestivo($anio . '-11-03', 2, 2),
            'tipo' => 'festivo',
            'prioridad' => 7
        ],
        
        // TEMPORADA DE COSTA - Rango amplio
        [
            'id' => 'temporada_costa',
            'title' => 'Temporada de Costa',
            'fecha' => $anio . '-12-15/' . ($anio + 1) . '-05-15',
            'tipo' => 'temporada',
            'prioridad' => 5
        ],
        
        // TEMPORADA DE SIERRA - Rango amplio
        [
            'id' => 'temporada_sierra',
            'title' => 'Temporada de Sierra',
            'fecha' => $anio . '-06-01/' . $anio . '-10-15',
            'tipo' => 'temporada',
            'prioridad' => 5
        ],
        
        // BLACK FRIDAY - Rango extendido (semana del Black Friday)
        [
            'id' => 'black_friday',
            'title' => 'Black Friday',
            'fecha' => calcularRangoFestivo(calcularBlackFriday($anio), 2, 4),
            'tipo' => 'comercial',
            'prioridad' => 6
        ],
        
        // DÍA DE LA MADRE (segundo domingo de mayo) - Rango extendido
        [
            'id' => 'dia_madre',
            'title' => 'Día de la Madre',
            'fecha' => calcularRangoFestivo(calcularDiaMadre($anio), 3, 3),
            'tipo' => 'especial',
            'prioridad' => 6
        ],
        
        // DÍA DEL PADRE (tercer domingo de junio) - Rango extendido
        [
            'id' => 'dia_padre',
            'title' => 'Día del Padre',
            'fecha' => calcularRangoFestivo(calcularDiaPadre($anio), 3, 3),
            'tipo' => 'especial',
            'prioridad' => 6
        ],
        
        // FESTIVOS SIN RANGO AMPLIO (solo el día específico)
        [
            'id' => 'dia_trabajo',
            'title' => 'Día del Trabajo',
            'fecha' => $anio . '-05-01',
            'tipo' => 'festivo',
            'prioridad' => 7
        ],
        [
            'id' => 'batalla_pichincha',
            'title' => 'Batalla de Pichincha',
            'fecha' => $anio . '-05-24',
            'tipo' => 'festivo',
            'prioridad' => 7
        ],
        [
            'id' => 'primer_grito',
            'title' => 'Primer Grito de Independencia',
            'fecha' => $anio . '-08-10',
            'tipo' => 'festivo',
            'prioridad' => 7
        ]
    ];
    
    // Ordenar por prioridad (más alta primero)
    usort($temporadas, function($a, $b) {
        return $b['prioridad'] - $a['prioridad'];
    });
    
    // Buscar la temporada/festivo para la fecha dada
    foreach ($temporadas as $temporada) {
        if (esFechaEnRango($fechaStr, $temporada['fecha'])) {
            return [
                'id' => $temporada['id'],
                'title' => $temporada['title'],
                'tipo' => $temporada['tipo'],
                'prioridad' => $temporada['prioridad']
            ];
        }
    }
    
    // Si no está en ninguna temporada especial
    return [
        'id' => 'normal',
        'title' => 'Día Normal',
        'tipo' => 'normal',
        'prioridad' => 0
    ];
}

// FUNCIONES AUXILIARES MEJORADAS

function calcularRangoFestivo($fechaCentral, $diasAntes, $diasDespues) {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaCentral);
    $inicio = clone $fecha;
    $inicio->modify("-$diasAntes days");
    $fin = clone $fecha;
    $fin->modify("+$diasDespues days");
    
    return $inicio->format('Y-m-d') . '/' . $fin->format('Y-m-d');
}

function calcularCarnaval($anio) {
    $pascua = calcularPascua($anio);
    $carnaval = clone $pascua;
    $carnaval->modify('-47 days');
    return $carnaval->format('Y-m-d');
}

function calcularViernesSanto($anio) {
    $pascua = calcularPascua($anio);
    $viernesSanto = clone $pascua;
    $viernesSanto->modify('-2 days');
    return $viernesSanto->format('Y-m-d');
}

function calcularDiaMadre($anio) {
    // Segundo domingo de mayo
    $mayo = new DateTime($anio . '-05-01');
    $primerDomingo = clone $mayo;
    $primerDomingo->modify('first sunday of may');
    $segundoDomingo = clone $primerDomingo;
    $segundoDomingo->modify('+1 week');
    return $segundoDomingo->format('Y-m-d');
}

function calcularDiaPadre($anio) {
    // Tercer domingo de junio
    $junio = new DateTime($anio . '-06-01');
    $primerDomingo = clone $junio;
    $primerDomingo->modify('first sunday of june');
    $tercerDomingo = clone $primerDomingo;
    $tercerDomingo->modify('+2 weeks');
    return $tercerDomingo->format('Y-m-d');
}

function calcularPascua($anio) {
    // Algoritmo para calcular Domingo de Pascua
    $a = $anio % 19;
    $b = floor($anio / 100);
    $c = $anio % 100;
    $d = floor($b / 4);
    $e = $b % 4;
    $f = floor(($b + 8) / 25);
    $g = floor(($b - $f + 1) / 3);
    $h = (19 * $a + $b - $d - $g + 15) % 30;
    $i = floor($c / 4);
    $k = $c % 4;
    $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
    $m = floor(($a + 11 * $h + 22 * $l) / 451);
    $mes = floor(($h + $l - 7 * $m + 114) / 31);
    $dia = (($h + $l - 7 * $m + 114) % 31) + 1;
    
    return DateTime::createFromFormat('Y-m-d', $anio . '-' . $mes . '-' . $dia);
}

function calcularBlackFriday($anio) {
    $noviembre = new DateTime($anio . '-11-01');
    $primerJueves = clone $noviembre;
    $primerJueves->modify('first thursday of november');
    $cuartoJueves = clone $primerJueves;
    $cuartoJueves->modify('+3 weeks');
    $blackFriday = clone $cuartoJueves;
    $blackFriday->modify('+1 day');
    return $blackFriday->format('Y-m-d');
}

function esFechaEnRango($fecha, $rango) {
    // Si es un rango de fechas (ej: "2024-12-15/2025-04-30")
    if (strpos($rango, '/') !== false) {
        list($inicio, $fin) = explode('/', $rango);
        return $fecha >= $inicio && $fecha <= $fin;
    }
    
    // Si es una fecha específica
    return $fecha === $rango;
}

// FUNCIÓN PARA OBTENER INFO COMPLETA DE TEMPORADA
function obtenerInfoTemporadaCompleta($fecha = null) {
    return obtenerTemporadaEcuador($fecha);
}

// EJEMPLOS DE USO
/*
// Obtener temporada actual con información completa
$temporadaActual = obtenerTemporadaEcuador();
echo "ID: " . $temporadaActual['id'] . "\n";
echo "Título: " . $temporadaActual['title'] . "\n";
echo "Tipo: " . $temporadaActual['tipo'] . "\n";

// Probar fechas en rangos
$fechasPrueba = [
    '2024-12-20', // En rango de Navidad
    '2024-12-30', // En rango de Año Nuevo
    '2024-02-10', // Posiblemente en rango de Carnaval
    '2024-11-01', // En rango de Día de Difuntos
    '2024-08-15', // En Mes de la Patria
    '2024-05-10', // En rango de Día de la Madre
];

foreach ($fechasPrueba as $fecha) {
    $temporada = obtenerTemporadaEcuador($fecha);
    echo "Fecha: $fecha - Temporada: {$temporada['title']} ({$temporada['id']})\n";
}
*/
?>