<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
switch ($_SERVER['REQUEST_METHOD']) {

  case 'POST':
    $_POST = json_decode(file_get_contents('php://input'), true);
    checkOut();

  break;
}

function checkOut(){
    if(!isset($_POST['cart']) || !isset($_POST['user'])){
        http_response_code(400);
        echo 'No hay articulos en el carrito, o no estas logeado';
    }
    else{
        $cart = $_POST['cart'];
        $user = $_POST['user'];
        sendMailtoAdmin($user, $cart);
    }
}

function sendMailtoAdmin($user, $cart){
    $siteOwnersEmail = 'carlmarcast@gmail.com';

    $name = trim(stripslashes($user['name']));
    $email = trim(stripslashes($user['email']));
    $subject = 'Pedido realizado por: '.$user['name'];

    $message =''; 
    $message .= "Pedido de: " . $name . "<br />";
    $message .= "Email: " . $email . "<br />";
    $message .= 'Productos: <br />';
    foreach ($cart as $producto){
        $message .= 'Producto: '.$producto['name'].'. Precio: '.$producto['price'].'€ <br />';
    };
    $message .= "<br /> ----- <br /> Pedido realizado en PaulaLoveDesigner. <br />";

    $from =" <" . $siteOwnersEmail . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    ini_set("sendmail_from", $siteOwnersEmail); // for windows server
    
    $mail = mail($siteOwnersEmail, $subject, $message, $headers);

    if ($mail) { sendMailtoUser($user, $cart); }
    else{
        http_response_code(404);
        echo 'Se ha producido un error intentelo mas tarde';
    }
}

function sendMailtoUser($user, $cart){
    $siteOwnersEmail = 'carlmarcast@gmail.com';

    $name = trim(stripslashes($user['name']));
    $email = trim(stripslashes($user['email']));
    $subject = 'Pedido realizado por: '.$user['name'];

    $message =''; 
    $message .= "Pedido de: " . $name . "<br />";
    $message .= "Email: " . $email . "<br />";
    $message .= 'Productos: <br />';
    foreach ($cart as $producto){
        $message .= 'Producto: '.$producto['name'].'. Precio: '.$producto['price'].'€ <br />';
    };
    $message .= "<br /> ----- <br /> Pedido realizado en PaulaLoveDesigner. <br />";

    $from =" <" . $siteOwnersEmail . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    ini_set("sendmail_from", $siteOwnersEmail); // for windows server
    
    $mail = mail($email, $subject, $message, $headers);

    if ($mail) { 
        echo json_encode("OK");
        http_response_code(200); }
    else{
        http_response_code(404);
        echo 'Se ha producido un error intentelo mas tarde';
    }
}

?>