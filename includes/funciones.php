<?php

define('FUNCIONES_URL', __DIR__ . "/funciones/funciones.php");
define('TEMPLATES_URL', __DIR__ . "/templates");
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false, int $limite = null)
{
    require TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado($url): bool
{
    session_start();

    if (!$_SESSION['login']) {
        header('location: /');
    }

    return true;
}


function debugear($variable = null)
{

    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

//Escapar / Sanitizar  el Html
//htmlspecialchars sirve para escapar HTML
function s($html)
{
    $s = htmlspecialchars($html);
    return $s;
}


function selectId($tipo)
{
    $tipos = ['vendedor', 'propiedades'];
    return in_array($tipo, $tipos);
}

function validarORedireccionar(string $url)
{
    // Verificar el id
    $id =  $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) {
        header("Location: $url");
    }

    return $id;
}
