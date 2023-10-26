<?php

namespace Controllers;

use Model\Propiedad;
use Model\Login;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class PaginaController
{

    public static function index(Router $router)
    {

        $propiedades = Propiedad::get($limite = 3);
        $inicio = true;
        $router->render('paginas/index', [
            'inicio' =>  $inicio,
            'propiedades' => $propiedades
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function anuncios(Router $router)
    {
        $propiedades = Propiedad::getAll();
        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            $propiedad = Propiedad::find($id);
        } else {
            header('Location: /');
        }
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', []);
    }
    public static function login(Router $router)
    {
        $errores = Login::getErrores();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST)) {

                $nombre = $_POST['email'];
                $usuario = new Login($_POST);
                $errores = $usuario->validarDatos();


                if (empty($errores)) {
                    //Verificar si el usuario existe
                    $usuarioDB = $usuario->existeUsuario();
                    if ($usuarioDB) {
                        //Verificar Password es igual al de la BD
                        $auth = $usuario->comprobarPassword($usuarioDB->password);
                        if ($auth) {
                            //Esta autenticado
                            // Para autenticar usuarios estaremos utilizando la superglobal SESSION, esta va a mantener eso una sesión activa en caso de que sea valida.
                            session_start();
                            $_SESSION['usuario'] = $usuarioDB->email;
                            $_SESSION['id'] = $usuarioDB->id;
                            $_SESSION['login'] = true;
                            header('Location: /admin');
                        } else {
                            $errores = Login::getErrores();
                        }
                    } else {
                        $errores = Login::getErrores();
                    }
                }
            }
        }

        $router->render('paginas/login', [
            'errores' => $errores
        ]);
    }


    public static function logout()
    {
        session_start();
        if ($_SESSION) {
            $_SESSION = [];
            header('Location: /');
        }
    }


    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router)
    {

        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = $_POST['contacto'];


            //Crear una Instancia de PHPMAILER
            $phpmailer = new PHPMailer();

            //Configurar SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['EMAIL_HOST'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = $_ENV['EMAIL_PORT'];
            $phpmailer->Username = $_ENV['EMAIL_USER'];
            $phpmailer->Password = $_ENV['EMAIL_PASS'];
            $phpmailer->SMTPSecure = 'tls';

            //Quien ENVIA con setFROM y donde recibe en addAdrress
            $phpmailer->setFrom('admin@bienesraices.com', 'BienesRaices.com'); //Quien Envia
            $phpmailer->addAddress('admin@bienesraices.com');     //Agregar Receptor

            //Contenido del Email
            //Habilitar HTML
            $phpmailer->isHTML(true);  //Permitimos HTML
            //Codificacioon UTF-8
            $phpmailer->CharSet = 'UTF-8';
            //Titulo cuando llega el mensaje antes de entrar al mismo
            $phpmailer->Subject = 'Tienes un nuevo Mensaje';

            //Contenido
            $contenido = "<p>Contenido de Mensaje</p>";
            $contenido .= "Nombre: " . $datos['nombre'] . "<br>";
            $contenido .= " Email: " . $datos['email'] . "<br>";
            $contenido .= " Telefono: " . $datos['telefono'] . "<br>";
            $contenido .= " Mensaje: " . $datos['mensaje'] . "<br>";
            $contenido .= " Precio: $" . $datos['precio'] . "<br>";
            $contenido .= " Fecha: " . $datos['fecha'] . "<br>";
            $contenido .= " Hora: " . $datos['hora'] . "<br>";


            $phpmailer->Body = $contenido; //Con HTML
            $phpmailer->AltBody = 'Este es un nuevo Email. Buenos Dias'; //Alternativo en caso de que no soporte HTML el servicio de mail
            $resultado = $phpmailer->send();


            if ($phpmailer->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar: {$phpmailer->ErrorInfo}";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
