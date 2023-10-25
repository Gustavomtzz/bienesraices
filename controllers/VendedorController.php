<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{

    public static function crear(Router $router)
    {
        $vendedor = new Vendedor;
        $errores = Vendedor::getErrores();

        //Cuando se ENVIA el FORMULARIO MEDIANTE POST.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //INSTANCIO una nueva propiedad
            $vendedor = new Vendedor($_POST);

            /*VALIDACION DE FORMULARIO */

            //Valido los Datos del Formulario
            $vendedor->validarDatos();
            //Asigno a $errores el arreglo de errores dentro de la clase
            $errores = Vendedor::getErrores();

            //Si errores esta Vacio. Continuo.
            if (empty($errores)) {
                //Guardo en la DB la propiedad. Y asigno en una Variable el resultado(true,false) para Redireecionar mas Abajo
                $vendedor->guardar();
            }
        }


        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        // Verificar el id
        $id =  $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //Consultar TABLA VENDEDORES. Para ASIGNARLOS en el SELECT del FORMULARIO
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $vendedor->sincronizar($_POST);

            $errores = $vendedor->validarDatos();

            // El array de errores esta vacio
            if (empty($errores)) {

                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }


    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar el id
            $id =  $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            }
        }
    }
}
