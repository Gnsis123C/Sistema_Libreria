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

            //EMPRESA
            $routes->get('empresa/', 'Ctr_empresa::index', ['as'=>'empresa']);
            $routes->post('empresa/', 'Ctr_empresa::action', ['as'=>'empresa.actions']);
            $routes->post('empresa/select/', 'Ctr_empresa::selectBD', ['as'=>'empresa.select']);

            //CATEGORIAS
            $routes->get('categoria/', 'Ctr_categoria::index', ['as'=>'categoria']);
            $routes->get('categoria/add/', 'Ctr_categoria::crear', ['as'=>'categoria.crear']);
            $routes->get('categoria/edit/(:num)', 'Ctr_categoria::editar/$1', ['as'=>'categoria.editar']);
            $routes->post('categoria/', 'Ctr_categoria::action', ['as'=>'categoria.actions']);
            $routes->post('categoria/select/', 'Ctr_categoria::selectBD', ['as'=>'categoria.select']);
            $routes->get('categoria/validar/nombre/', 'Ctr_categoria::nombre', ['as'=>'categoria.validar.nombre']);

            //CATEGORIAS
            $routes->get('atributo/', 'Ctr_atributo::index', ['as'=>'atributo']);
            $routes->get('atributo/add/', 'Ctr_atributo::crear', ['as'=>'atributo.crear']);
            $routes->get('atributo/edit/(:num)', 'Ctr_atributo::editar/$1', ['as'=>'atributo.editar']);
            $routes->post('atributo/', 'Ctr_atributo::action', ['as'=>'atributo.actions']);
            $routes->post('atributo/select/', 'Ctr_atributo::selectBD', ['as'=>'atributo.select']);
            $routes->get('atributo/validar/nombre/', 'Ctr_atributo::nombre', ['as'=>'atributo.validar.nombre']);

            //PERSONA
            $routes->get('persona/(:segment)', 'Ctr_persona::index/$1', ['as'=>'persona']);
            $routes->get('persona/(:any)/add/', 'Ctr_persona::crear/$1', ['as'=>'persona.crear']);
            $routes->get('persona/(:any)/edit/(:num)', 'Ctr_persona::editar/$1/$2', ['as'=>'persona.editar']);
            $routes->post('persona/(:any)/', 'Ctr_persona::action/$1', ['as'=>'persona.actions']);
            $routes->post('persona/(:any)/select/', 'Ctr_persona::selectBD/$1', ['as'=>'persona.select']);
            $routes->get('persona/validar/nombre/', 'Ctr_persona::nombre', ['as'=>'persona.validar.nombre']);
            $routes->get('persona/validar/cedula_ruc/', 'Ctr_persona::cedula_ruc', ['as'=>'persona.validar.cedula_ruc']);

            //PRODUCTOS
            $routes->get('producto/', 'Ctr_producto::index', ['as'=>'producto']);
            $routes->get('producto/add/', 'Ctr_producto::crear', ['as'=>'producto.crear']);
            $routes->get('producto/edit/(:num)', 'Ctr_producto::editar/$1', ['as'=>'producto.editar']);
            $routes->post('producto/', 'Ctr_producto::action', ['as'=>'producto.actions']);
            $routes->post('producto/select/', 'Ctr_producto::selectBD', ['as'=>'producto.select']);
            $routes->get('producto/validar/nombre/', 'Ctr_producto::nombre', ['as'=>'producto.validar.nombre']);
            $routes->get('producto/validar/codigo_barras/', 'Ctr_producto::codigo_barras', ['as'=>'producto.validar.codigo_barras']);

            //VALOR ATRIBUTO
            $routes->post('valoratributo/select/', 'Ctr_valoratributo::selectBD', ['as'=>'valoratributo.select']);

        });
    });
});

$routes->set404Override(function() {
    return '<meta http-equiv="refresh" content="0; url='.base_url(route_to('iniciar')).'">';
});