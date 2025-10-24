<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php"; 

$area = $_GET["area"] ?? "";

$sql = "SELECT u_idUsuario, u_nombre, u_DNI, puntaje FROM usuario WHERE u_Area = :area";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":area", $area);
$stmt->execute();


$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resultado);

?>

