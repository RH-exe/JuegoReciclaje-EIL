<?php
$local ="localhost";
$port = "3306";
$db="recycling_web";
$username ="root";
$contra ="";

try{
    $conexion =  new PDO("mysql:host=$local;port=$port;dbname=$db;charset=utf8",$username,$contra);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error con la conexion" .$e->getMessage());
}
?>