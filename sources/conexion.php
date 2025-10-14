<?php
header("Content-Type: application/json; charset=utf-8");
$local ="localhost";
$port = "3306";
$db="recycling_web";
$username ="root";
$contra ="root";

try{
    $conexion =  new PDO("mysql:host=$local;port=$port;dbname=$db;charset=utf8",$username,$contra);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
    exit;
}
?>