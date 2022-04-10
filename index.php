<?php

switch ($_SERVER['REQUEST_METHOD']) {

  case 'POST':

    $_POST = json_decode(file_get_contents('php://input'), true);
    insertUser();

  break;

  case 'GET':
    echo 'Pedir'; 
  break;

  case 'PUT':
    echo 'Editar';   
  break;
  
  case 'DELETE':
    echo 'Eliminar';   
  break;
}

function insertUser(){
  
require __DIR__ . "/dbConnection/mongoDbConnection.php";

  $resultado = $Users->insertOne( [ 'name' => $_POST['name'], 'password' => $_POST['password'] ] );

  if ($resultado) {
    print 'id: '. $resultado->getInsertedId() . ' insertado correctamente';
  }

}

?>