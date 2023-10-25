<?php

namespace MVC;

include_once "includes/app.php";

class Router
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    {

        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }
    public function comprobarRutas()
    {
        $rutasProtegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];
        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];


        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {

            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        if (in_array($urlActual, $rutasProtegidas)) {
            estaAutenticado($urlActual);
        }


        if ($fn) {
            //Si la funcion Existe
            //Llama a la funcion con call_user_func
            call_user_func($fn, $this);
        } else {
            echo 'ERROR 404 [Página no encontrada]';
        }
    }

    //Muestra una Vista
    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); //Almacenamiento en memoria durante un tiempo...
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); //Limpia el Buffer
        include_once __DIR__ . "/views/layout.php";
    }
}
