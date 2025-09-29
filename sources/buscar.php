<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php"; // 👈 ya que buscar.php y conexion.php están en la misma carpeta




$area = $_GET["area"] ?? "";

$sql = "SELECT u_idUsuario, u_nombre FROM usuarios WHERE u_Area = :area";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":area", $area);
$stmt->execute();

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resultado);

?>

