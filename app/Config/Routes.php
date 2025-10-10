<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index', ['as'=>'login']);

// Definir $uriCustom con un valor predeterminado si no hay sesión
$uriCustom = "app"; // Ruta base si no hay sesión (puedes cambiarla)

if(session('usuario')){
	$nameUriCustom = url_title(strtolower(session('empresa')["nombre"]))."/".url_title(strtolower(session('usuario')['usuario']));
	$uriCustom = $nameUriCustom;
}

$routes->post('/', 'Login::iniciar', ['as'=>'iniciar']);
$routes->get('/salir', 'Login::salir', ['as'=>'salir']);

$routes->group($uriCustom,['filter'=>'Sessionadmin'], function($routes){
    $routes->get('inicio/', 'Home::index', ['as'=>'inicio']);
});

$routes->group($uriCustom,['filter'=>'Sessionadmin'], function($routes){
    $routes->get('empresa/', 'Ctr_empresa::index', ['as'=>'empresa']);
    $routes->get('empresa/add/', 'Ctr_empresa::crear', ['as'=>'empresa.crear']);
    $routes->get('empresa/edit/(:num)', 'Ctr_empresa::editar/$1', ['as'=>'empresa.editar']);
    $routes->post('empresa/', 'Ctr_empresa::action', ['as'=>'empresa.actions']);
    $routes->post('empresa/select/', 'Ctr_empresa::selectBD', ['as'=>'empresa.select']);
    $routes->get('empresa/validar/correo/', 'Ctr_empresa::correo', ['as'=>'empresa.validar.correo']);

    //CLIENTES
    $routes->get('persona/', 'Ctr_cliente::index', ['as'=>'cliente']);
    $routes->get('persona/add/', 'Ctr_cliente::crear', ['as'=>'cliente.crear']);
    $routes->get('persona/edit/(:num)', 'Ctr_cliente::editar/$1', ['as'=>'cliente.editar']);
    $routes->post('persona/', 'Ctr_cliente::action', ['as'=>'cliente.actions']);
    $routes->post('persona/select/', 'Ctr_cliente::selectBD', ['as'=>'cliente.select']);
    $routes->post('persona/select/proveedor', 'Ctr_cliente::selectBDProveedor', ['as'=>'cliente.select.proveedor']);
    $routes->get('persona/validar/ci/', 'Ctr_cliente::ci', ['as'=>'cliente.validar.ci']);

    //CATEGORIAS
    $routes->get('categoria/', 'Ctr_categoria::index', ['as'=>'categoria']);
    $routes->get('categoria/add/', 'Ctr_categoria::crear', ['as'=>'categoria.crear']);
    $routes->get('categoria/edit/(:num)', 'Ctr_categoria::editar/$1', ['as'=>'categoria.editar']);
    $routes->post('categoria/', 'Ctr_categoria::action', ['as'=>'categoria.actions']);
    $routes->post('categoria/select/', 'Ctr_categoria::selectBD', ['as'=>'categoria.select']);
    $routes->get('categoria/validar/nombre/', 'Ctr_categoria::nombre', ['as'=>'categoria.validar.nombre']);

    //PRODUCTOS
    $routes->get('producto/', 'Ctr_producto::index', ['as'=>'producto']);
    $routes->get('producto/add/', 'Ctr_producto::crear', ['as'=>'producto.crear']);
    $routes->get('producto/edit/(:num)', 'Ctr_producto::editar/$1', ['as'=>'producto.editar']);
    $routes->post('producto/', 'Ctr_producto::action', ['as'=>'producto.actions']);
    $routes->post('producto/select/', 'Ctr_producto::selectBD', ['as'=>'producto.select']);
    $routes->get('producto/validar/nombre/', 'Ctr_producto::nombre', ['as'=>'producto.validar.nombre']);

    //ATRIBUTO
    $routes->get('atributo/', 'Ctr_atributo::index', ['as'=>'atributo']);
    $routes->get('atributo/add/', 'Ctr_atributo::crear', ['as'=>'atributo.crear']);
    $routes->get('atributo/edit/(:num)', 'Ctr_atributo::editar/$1', ['as'=>'atributo.editar']);
    $routes->post('atributo/', 'Ctr_atributo::action', ['as'=>'atributo.actions']);
    $routes->post('atributo/select/', 'Ctr_atributo::selectBD', ['as'=>'atributo.select']);
    $routes->get('atributo/validar/nombre/', 'Ctr_atributo::nombre', ['as'=>'atributo.validar.nombre']);

    //VALOR ATRIBUTO
    $routes->post('valoratributo/select/', 'Ctr_valoratributo::selectBD', ['as'=>'valoratributo.select']);

    //COMPRA
    $routes->get('compra/', 'Ctr_compra::index', ['as'=>'compra']);
    $routes->get('compra/add/', 'Ctr_compra::crear', ['as'=>'compra.crear']);
    $routes->get('compra/edit/(:num)', 'Ctr_compra::editar/$1', ['as'=>'compra.editar']);
    $routes->post('compra/', 'Ctr_compra::action', ['as'=>'compra.actions']);
    $routes->post('compra/select/', 'Ctr_compra::selectBD', ['as'=>'compra.select']);
});