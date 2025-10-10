<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(){
        $data = [
            'titulo'   =>  'Inicio',
            'pagina'    =>  'inicio',
            'breadcrumb' => array(
                array(
                    'url' => base_url().route_to('inicio'),
                    'name' => 'Inicio'
                )
            )
        ];
        return view('inicio', $data);
    }
}
