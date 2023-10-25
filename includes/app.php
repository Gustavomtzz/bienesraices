<?php


//Classes

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

require  'config/database.php';
require 'funciones.php';


//Dot Env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

//Conectar a la DB
$db = conectarDb();
ActiveRecord::setDB($db);
