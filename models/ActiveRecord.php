<?php

namespace Model;


class ActiveRecord
{
    //Base de datos
    protected static $db;
    //Tabla de BD
    protected static $tabla = '';
    //Mapear Atributos
    protected static $columnasDB = [];
    //Errores
    protected static $errores = [];

    public $id;
    public $imagen;


    //Setear DataBase;
    public static function setDB($database)
    {
        self::$db = $database;
    }

    //Obtener Errores
    public static function getErrores()
    {
        return static::$errores;
    }


    public static function getAll()
    {


        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);
        // $stmt = self::$db->prepare($query);
        // $stmt->execute();
        // $resultados = $stmt->get_result();
        // $propiedad = $resultados->fetch_all(MYSQLI_ASSOC);

        return $resultado;
    }

    public static function get(int $limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limite;

        $resultado = self::consultarSQL($query);
        // $stmt = self::$db->prepare($query);
        // $stmt->execute();
        // $resultados = $stmt->get_result();
        // $propiedad = $resultados->fetch_all(MYSQLI_ASSOC);
        return $resultado;
    }

    public static function find($id)
    {
        $idS = self::$db->escape_string($id);
        //Query
        $query = "SELECT * FROM " . static::$tabla . " WHERE id= $idS";

        //Formatear como Objeto mediante el metodo ConsultarSql
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los Resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        };

        //Liberar la memoria
        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    public function guardar()
    {

        if (isset($this->id)) {
            //Actualizando un registro
            $this->actualizar();
        } else {
            //Creando un nuevo registro
            $this->crear();
        }
    }
    public function actualizar()
    {
        //Sanitizar Datos
        $sanitizado = $this->sanitizarDatos();


        $valores = [];

        foreach ($sanitizado as $key => $value) {
            $valores[] = "$key='$value'";
        }
        $valoresStr = join(', ', $valores);

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= $valoresStr;
        $query .= " WHERE id=" . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?mensaje=2');
        }
    }

    public function crear()
    {
        //Sanitizar Datos
        $sanitizado = $this->sanitizarDatos();

        //Separar KEYS del array asociativo.Y Generar un STRING del ARRAY mediante JOIN
        $llaves = array_keys($sanitizado);
        $stringLlaves = join(', ', $llaves);

        //Separar VALUES del Array Asociativo. Y Generar un STRING del ARRAY mediante JOIN
        $valores = array_values($sanitizado);
        $stringValores = join("', '", $valores);

        //CREAR el Query a Insertar
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= $stringLlaves;
        $query .= " )  VALUES (' ";
        $query .=  $stringValores;
        $query .= " ') ";
        //Insertar en la DB
        $resultado = self::$db->query($query);


        //Reedirecciono en caso de TRUE al admin index
        if ($resultado) {
            header('location:/admin?mensaje=1');
        }
    }

    //Identificar y unir los atributos de la BD. Y tenerlos en memoria
    public function atributos()
    {
        $argumentos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $argumentos[$columna] = $this->$columna;
        }

        return $argumentos;
    }


    //Subida de Archivos
    public function setImagen(string $imagen)
    {
        if (isset($this->id)) {
            //Eliminar la imagen Anterior
            $this->borrarImagen();
        }

        //Crear una nueva Imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }


    //Eliminar Archivo
    public  function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Validar Datos 
    public function validarDatos()
    {
        //Limpiar Array Errores
        static::$errores = [];

        // Validar Campos
        return static::$errores;
    }

    //Sanitiza los datos
    public function sanitizarDatos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        //Iteramos LLAVE y VALOR del arreglo $atributos.
        // Para iterar llave y valor en FOREACH utilizamos $variable1 = llave; "=>" une el valor; $variable2 = Valor;
        foreach ($atributos as $key => $value) {

            //Sanitizamos cada VALOR mediante "escape_string()"
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //Eliminar Datos
    public  function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id=" . self::$db->escape_string($this->id) . " LIMIT 1";
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute();


        //If true, redireccionamos
        if ($resultado) {
            $this->borrarImagen();
            header('location: /admin?mensaje=3');
        }
    }


    public  function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
