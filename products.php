<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
switch ($_SERVER['REQUEST_METHOD']) {

  case 'POST':

    $_POST = json_decode(file_get_contents('php://input'), true);
    insertProduct();

  break;

  case 'GET': 

    if(isset($_GET['_id'])){
      getProductById($_GET['_id']);
    }
    else{
      getAllProducts();
    }
  break;

  case 'PUT':
    echo 'Editar';   
  break;
  
  case 'DELETE':
    echo 'Eliminar';   
  break;
}

function insertProduct(){
  
require __DIR__ . "/dbConnection/mongoDbConnection.php";

  $resultado = $Products->insertOne( [ 'name' => $_POST['name'], 'price' => $_POST['price'], 'description' => $_POST['description'], 'stock' => $_POST['stock'] ] );

  if ($resultado) {
    return;
  }

}

function getProductById($id){
  require __DIR__ . "/dbConnection/mongoDbConnection.php";
  
    $resultado = $Products->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    
    if ($resultado) {
      echo json_encode($resultado);
    }
}

function getAllProducts(){
  
  require __DIR__ . "/dbConnection/mongoDbConnection.php";
  
    $resultado = $Products->find()->toArray();

    if ($resultado) {
      echo json_encode($resultado);
    }
  
  }

?>