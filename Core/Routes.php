<?php 

function getController($controller){
  //Obtener nombre del controlador
  $controllerName = strtolower($controller).'Controller';

  // Obtener el nombre del archivo del Controlador
  $controllerFile = "Controllers/$controller" . 'Controller.php';

  // Validar si el archivo existe, si no existe, cargar el controlador por defecto
  if(!is_file($controllerFile)){
    $controllerFile = "Controllers/".strtolower(DEFAULT_CONTROLLER).'Controller.php';
    $controllerName = strtolower(DEFAULT_CONTROLLER).'Controller';
  }

  // Cargar el controlador
  require_once $controllerFile;

  // Inicializar y retornar el controlador
  $ctrl = new $controllerName();
  return $ctrl;
}

function getFunction($action, $controller){

  // Obtener el nombre del método
  $actionName = strtolower($action).'Action';

  //Si el metodo no existe, cargar el metodo por defecto
  if(!$action){
    $actionName = strtolower(DEFAULT_FUNCTION).'Action';
  }

  // Se ejecuta el método
  $controller->$actionName();
}
