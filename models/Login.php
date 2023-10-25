<?php

namespace Model;

use Model\ActiveRecord;


class Login extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }


    //Validar Datos 
    public function validarDatos()
    {
        // Validar Campos
        if (!$this->email) {
            self::$errores[] = "El campo email esta vacio.";
        }
        if (!$this->password) {
            self::$errores[] = "El campo password esta vacio.";
        }

        // Devuelvo el Arreglo
        return self::$errores;
    }

    public function existeUsuario()
    {
        $emailS = self::$db->escape_string($this->email);
        //Query
        $query = "SELECT * FROM " . self::$tabla . " WHERE email='" . $emailS . "' LIMIT 1;";

        //Formatear como Objeto mediante el metodo ConsultarSql
        $resultado = self::consultarSQL($query);
        if (empty($resultado)) {
            self::$errores[] = 'El Usuario no existe';
            return;
        }
        return array_shift($resultado);
    }

    public function comprobarPassword($passwordHash)
    {
        $auth = password_verify($this->password, $passwordHash);
        if (!$auth) {
            self::$errores[] = 'El Password es incorrecto';
        }

        return $auth;
    }
}
