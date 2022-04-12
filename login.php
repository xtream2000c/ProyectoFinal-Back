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
}

function insertUser(){
  
    require __DIR__ . "/dbConnection/mongoDbConnection.php";
    if(!isset($_POST['username']) || !isset($_POST['password'])){
        http_response_code(400);
        echo 'No se ha introducido usuario o contraseña';
    }
    else{
        $resultado = $Users->findOne( [ 'username' => $_POST['username'], 'password' => $_POST['password'] ] );

        if ($resultado) {
            echo json_encode($resultado);
        }
        else{
            http_response_code(404);
            echo 'Usuario no encontrado';
        }
    }
}

?>