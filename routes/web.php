<?php
$router->get('/', function () use ($router) {
	return redirect(url('rrhh/alumnos_nominal'));
});

$router->get('/login', function () use ($router) {
	return view('layout.login');
});

$router->group(['prefix'=>'rrhh'],function () use($router) {
	$router->get('/alumnos_nominal', 'RRHH@alumnos_nominal');
	$router->get('/matriculas_por_seccion', 'RRHH@matriculas_por_seccion');
});