<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{

    public static function index(Router $router)
    {

        $propiedades = Propiedad::getAll();
        $mensaje = $_GET['mensaje'] ?? null;

        $router->render('admin', [
            'propiedades' => $propiedades,
            'mensaje' => $mensaje
        ]);
    }

    public static function crear(Router $router)
    {

        $propiedad = new Propiedad();
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::getAll();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //INSTANCIO una nueva propiedad
            $propiedad = new Propiedad($_POST);

            //* Subida de Archivos */
            //Generar un nombre unico a la imagen con la funcion md5
            $nombreImagen = md5(uniqid(rand(), true))  . ".jpg";

            if ($_FILES['imagen']['tmp_name']) {
                //Buscamos la IMAGEN con el metodo make de la api.
                $image = Image::make($_FILES['imagen']['tmp_name']);

                //Realizamos RESIZE de la IMAGEN cn el METODO fit;
                $image->fit(1280, 720, $callback = null, 'center');

                //Asignamos el nombre creado con md5 a la imagen
                $propiedad->setImagen($nombreImagen);
            }



            /*VALIDACION DE FORMULARIO */
            //Valido los Datos del Formulario
            $propiedad->validarDatos();
            //Asigno a $errores el arreglo de errores dentro de la clase
            $errores = Propiedad::getErrores();

            //Si errores esta Vacio. Continuo.
            if (empty($errores)) {

                //Creamos la Carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //Guardamos la Imagen en el Servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen, 100);

                //Guardo en la DB la propiedad. Y asigno en una Variable el resultado(true,false) para Redireecionar mas Abajo
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {

        $id = validarORedireccionar('/admin');
        //Buscar Propiedad
        $propiedad = Propiedad::find($id);

        //Errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST)) {

                //Asignar los atributos al Objeto en Memoria
                $propiedad->sincronizar($_POST);

                //Validar los Input
                $errores = $propiedad->validarDatos();

                //* Subida de Archivos */
                //Generar un nombre unico a la imagen con la funcion md5
                $nombreImagen = md5(uniqid(rand(), true))  . ".jpg";
                if ($_FILES['imagen']['tmp_name']) {


                    //Buscamos la IMAGEN con el metodo make de la api.
                    $image = Image::make($_FILES['imagen']['tmp_name']);

                    //Realizamos RESIZE de la IMAGEN cn el METODO fit;
                    $image->fit(1280, 720, $callback = null, 'center');

                    //Asignamos el nombre creado con md5 a la imagen
                    $propiedad->setImagen($nombreImagen);

                    //Guardamos la Imagen en el Servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen, 100);
                }

                // El array de errores esta vacio
                if (empty($errores)) {


                    $propiedad->guardar();
                }
            }
        }
        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        estaAutenticado();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }
        }
    }
}
