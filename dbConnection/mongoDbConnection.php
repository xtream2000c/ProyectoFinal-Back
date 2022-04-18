<?php

    require __DIR__ . "/dbAuth.php";
    require __DIR__ . "/../vendor/autoload.php";
    $db = new MongoDB\Client("mongodb+srv://{$dbuser}:{$dbpassword}@pld.e2oym.mongodb.net/test");
    $Users = $db->Users->Users;
    $Products = $db->Products->Products;
?>