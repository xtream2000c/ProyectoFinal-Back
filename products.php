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

    if(isset($_GET['id'])){
      getProductById($_GET['id']);
    }
    else{
      getAllProducts();
    }
  break;

  case 'PUT':
    $_POST = json_decode(file_get_contents('php://input'), true);
    updateProduct($_GET['id']);   
  break;
  
  case 'DELETE':
    deleteProduct($_GET['id']);   
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

function updateProduct($id){
  require __DIR__ . "/dbConnection/mongoDbConnection.php";
  
    $resultado = $Products->updateOne([ "_id" => new MongoDB\BSON\ObjectID($id) ] , [ '$set' => [ 'name' => $_POST['name'], 'price' => $_POST['price'], 'description' => $_POST['description'], 'stock' => $_POST['stock'] ]]);
    
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
  function deleteProduct($id){
    require __DIR__ . "/dbConnection/mongoDbConnection.php";
    
      $Products->deleteOne([ "_id" => new MongoDB\BSON\ObjectID($id) ]);
      echo json_encode("OK");
      
  }

?>