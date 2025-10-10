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

if ( ! function_exists('tipoCliente()')){
	function tipoCliente($text){

		if ($text == "1" ) {
	        return 'Proveedor';
	    }

		if ($text == "0" ) {
	        return "Cliente";
	    }

	    return "";
	}
}

if ( ! function_exists('btn_acciones()')){
	function btn_acciones($accionesList = ['all'], $url = '', $id = 0){
		$acciones = '';
		$num = 0;
		$restore = false;
		$elim = false;
		$editar = false;

		$restoreBtn = '<a class="btn btn-warning btn-sm mx-1" data-action="restore" data-id="'.$id.'" href="#">Recuperar</a>';
		$elimBtn = '<a class="btn btn-danger btn-sm mx-1" data-action="elim" data-id="'.$id.'" href="#">Eliminar</a>';
		$editarBtn = '<a class="btn btn-info btn-sm mx-1" href="'.$url.'">Editar</a>';

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

        return $acciones;
	}
}