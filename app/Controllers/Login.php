<?php

namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Empresa;

class Login extends BaseController
{
    public function index(){
        if(session('usuario') != null){
            return redirect()->to(route_to('inicio'));
        }

        return view('html/login/index');
    }

    public function iniciar(){
        try{
            if ($this->request->getMethod() == 'POST') {
                $rules = [
                    'usuario_pass' => 'required',
                    'usuario_text' => 'required'
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput();
                }

                $req    = $this->request;
                $pass   = $req->getPost('usuario_pass');
                $user   = $req->getPost('usuario_text');

                $usuarioBD  = new Usuario();
                $empresaDB  = new Empresa();
                $resp   = $usuarioBD
                            ->where('estado', 1)
                            ->where('usuario',strtolower($user))
                            ->first() ?? null;

                if(!$resp) return redirect()->to(base_url().route_to('login'))->with('mensaje','Usuario o contraseña ingresados incorrectos');

                if(password_verify($pass, $resp['pass'])){
                    $data = [
                        'usuario'   => $resp,
                        'empresa'   => $empresaDB->where('idempresa',strtolower($resp['idempresa']))->first()
                    ];
                    $session = session();
                    $session->set($data);
                    return redirect()->to(route_to('login'));
                }else{
                    return redirect()->to(route_to('login'))->with('mensaje','Usuario o contraseña ingresados incorrectos');
                }

            }else{
                return redirect()->to(base_url(route_to('login')))->with('mensaje','Usuario o contraseña ingresados incorrectos'.$this->request->getMethod());
            }
        } catch (\Exception $e) {
            // Captura el error de CSRF
            return redirect()->to(base_url().route_to('login'))
                ->with('error', 'Token CSRF faltante o inválido. Recarga la página e intenta nuevamente.');
        }
        
    }

    public function salir(){
       $session = session();
       $session->destroy();
       return redirect()->to(base_url().route_to('index'));
    }
}
