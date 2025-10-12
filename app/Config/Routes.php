<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas Públicas
$routes->get('/', 'Login::index', ['as' => 'login']);
$routes->post('/', 'Login::iniciar', ['as' => 'iniciar']);
$routes->get('/salir', 'Login::salir', ['as' => 'salir']);

// Rutas Protegidas por Grupo
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Rutas Comunes para todos los roles autenticados
    $routes->get('inicio', 'Home::index', ['as' => 'inicio']);
    
    // Rutas Específicas por Rol
    $routes->group('', ['filter' => 'role:admin'], function($routes) {
        // ADMIN ROUTES
        $routes->group('admin', function($routes) {
            //USUARIO
            $routes->get('usuario/', 'Ctr_usuario::index', ['as'=>'usuario']);
            $routes->get('usuario/add', 'Ctr_usuario::crear', ['as'=>'usuario.crear']);
            $routes->get('usuario/edit/(:num)', 'Ctr_usuario::editar/$1', ['as'=>'usuario.editar']);
            $routes->post('usuario/', 'Ctr_usuario::action', ['as'=>'usuario.actions']);
            $routes->post('usuario/select/', 'Ctr_usuario::selectBD', ['as'=>'usuario.select']);
            $routes->get('usuario/validar/email/', 'Ctr_usuario::email', ['as'=>'usuario.validar.email']);
            $routes->get('usuario/validar/usuario/', 'Ctr_usuario::usuario', ['as'=>'usuario.validar.usuario']);

            //ROL
            $routes->get('rol/', 'Ctr_rol::index', ['as'=>'rol']);
            $routes->get('rol/add', 'Ctr_rol::crear', ['as'=>'rol.crear']);
            $routes->get('rol/edit/(:num)', 'Ctr_rol::editar/$1', ['as'=>'rol.editar']);
            $routes->post('rol/', 'Ctr_rol::action', ['as'=>'rol.actions']);
            $routes->post('rol/select/', 'Ctr_rol::selectBD', ['as'=>'rol.select']);
            $routes->get('rol/validar/nombre/', 'Ctr_rol::nombre', ['as'=>'rol.validar.nombre']);
        });
    });
});

$routes->set404Override(function() {
    return '<meta http-equiv="refresh" content="0; url='.base_url(route_to('iniciar')).'">';
});