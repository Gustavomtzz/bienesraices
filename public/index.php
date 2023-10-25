<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

use Controllers\PaginaController;
use Controllers\PropiedadController;
use Controllers\VendedorController;

use Model\Propiedad;

$router = new Router;

/**ZONA PUBLICA */
//**PAGINAS ESTATICAS */
$router->get('/', [PaginaController::class, 'index']);
$router->get('/nosotros', [PaginaController::class, 'nosotros']);
$router->get('/anuncios', [PaginaController::class, 'anuncios']);
$router->get('/propiedad', [PaginaController::class, 'propiedad']);
$router->get('/blog', [PaginaController::class, 'blog']);
$router->get('/entrada', [PaginaController::class, 'entrada']);
$router->get('/contacto', [PaginaController::class, 'contacto']);
$router->post('/contacto', [PaginaController::class, 'contacto']);

//**LOGIN y AUTH */
$router->get('/login', [PaginaController::class, 'login']);
$router->post('/login', [PaginaController::class, 'login']);
$router->get('/logout', [PaginaController::class, 'logout']);

/**ZONA PRIVADA */
//** CRUD ADMIN PROPIEDADES Y VENDEDORES */
//Admin Listar
$router->get('/admin', [PropiedadController::class, 'index']);

//**Propiedades */
//Crear
$router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
//Actualizar
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
//Eliminar
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

//**Vendedores */
//Crear
$router->get('/vendedores/crear', [VendedorController::class, 'crear']);
$router->post('/vendedores/crear', [VendedorController::class, 'crear']);
//Actualizar
$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
//Eliminar
$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);


//**LOGIN y AUTH */


//**COMPROBAR RUTAS */
$router->comprobarRutas();
