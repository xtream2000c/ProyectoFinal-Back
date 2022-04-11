<?php
header('Content-Type: application/json; charset=utf-8');
switch ($_SERVER['REQUEST_METHOD']) {

  case 'POST':

    $_POST = json_decode(file_get_contents('php://input'), true);
    insertUser();

  break;

  case 'GET': 
    getAllUsers();
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

function getAllUsers(){
  
  require __DIR__ . "/dbConnection/mongoDbConnection.php";
  
    $resultado = $Users->find()->toArray();

    if ($resultado) {
      echo json_encode($resultado);
    }
  
  }

?>