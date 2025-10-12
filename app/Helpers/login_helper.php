<?php
function esConsedido($data, $url) {
	$CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('login');
	if ($user->idlogin!='1') {
		foreach ($data as $x):
			if($x->url==$url){
				return $x;
			}
		endforeach;
		if($url!='menu'){
			show_404();
		}
	} else { 
		$list = array(
			'iddetalleroles'=>'all',
			'url'=> $url,
			'idpagina'=>'all',
			'idgrupo'=>'all',
			'editar'=>'1',
			'crear'=>'1',
			'eliminar'=>'1',
			'listar'=>'1'
		); 
		return (object) $list;
	}
}

function esVisible($data, $url) {
	$CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('login');
	if ($user->idlogin!='1') { 
		foreach ($data as $x):
			if($x->url==$url){
				if($x->listar==1){
					return 'style="display:block"';
				}else{
					return 'style="display:none"';
				}
			}
		endforeach;
	} else {
		return 'style="display:block"';
	}
}

if ( ! function_exists('excluirCR()')){
	function excluirCR($data, $excluir){
		for ($i=0; $i < count($data); $i++) { 
            for ($j=0; $j < count($excluir) ; $j++) { 
                if($data[$i]['name']==$excluir[$j]){
                    \array_splice($data, $i, 1);
                }
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