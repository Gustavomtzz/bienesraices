<?php

namespace Model;

use Model\ActiveRecord;

class Vendedor extends ActiveRecord
{

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->telefono = $args['telefono'] ?? null;
    }

    //Validar Datos 
    public function validarDatos()
    {

        if (!$this->nombre) {
            self::$errores[] = "El campo nombre esta vacio.";
        }
        if (!$this->apellido) {
            self::$errores[] = "El campo apellido esta vacio.";
        }

        if (strlen($this->telefono) < 6) {
            self::$errores[] = "El campo telefono esta vacio o no es válido";
        }

        // Validar Campos
        return self::$errores;
    }
}
