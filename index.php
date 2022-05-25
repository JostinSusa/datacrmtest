<?php 

//Carga de configuración principal
require_once 'config.php';

// Obtencion de parametros para enrutamiento de funciones y controladores
$ctrl = $_GET['controller'];
$action = $_GET['action'];

//Carga de enrutamiento
require_once 'Core/Routes.php'; 

//Carga del layout principal
require_once 'Views/layout/Page.php';
