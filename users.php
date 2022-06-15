<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
switch ($_SERVER['REQUEST_METHOD']) {

  case 'POST':

    $_POST = json_decode(file_get_contents('php://input'), true);
    insertUser();

  break;

  case 'GET': 

    if(isset($_GET['_id'])){
      getUserById($_GET['_id']);
    }
    else{
      getAllUsers();
    }
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

  $resultado = $Users->insertOne( [ 'name' => $_POST['name'], 'email' => $_POST['email'], 'username' => $_POST['username'], 'password' => $_POST['password'], 'type' => $_POST['type'] ] );

  if ($resultado) {
    return;
  }

}

function getUserById($id){
  require __DIR__ . "/dbConnection/mongoDbConnection.php";
  
    $resultado = $Users->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    
    if ($resultado) {
      echo json_encode($resultado);
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