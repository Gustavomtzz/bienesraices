<?php

namespace Model;

use Model\ActiveRecord;


class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'baños', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $baños;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;


    public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? null;
        $this->precio = $args['precio'] ?? null;
        $this->imagen = $args['imagen'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
        $this->habitaciones = $args['habitaciones'] ?? null;
        $this->baños = $args['baños'] ?? null;
        $this->estacionamiento = $args['estacionamiento'] ?? null;
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? null;
    }

    //Validar Datos 
    public function validarDatos()
    {
        // Validar Campos
        if (!$this->titulo) {
            self::$errores[] = "El campo titulo esta vacio.";
        }
        if (!$this->precio) {
            self::$errores[] = "El campo precio esta vacio.";
        }
        if (strlen($this->precio) > 10) {
            self::$errores[] = "Precio no puede ser mayor a 10 caracteres";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es Obligatoria.";
        }

        if (strlen($this->descripcion) < 5) {
            self::$errores[] = "El campo descripción esta vacio.";
        }

        if (strlen($this->descripcion) > 240) {
            self::$errores[] = "Descripcion no puede ser mayor a 240 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El campo habitaciones esta vacio.";
        }
        if (!$this->baños) {
            self::$errores[] = "El campo baños esta vacio.";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "El campo estacionamiento esta vacio.";
        }
        if (!$this->vendedores_id) {
            self::$errores[] = "El campo vendedores esta vacio.";
        }

        // Validar Campos
        return self::$errores;
    }
}
