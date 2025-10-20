<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);
$usuario_id = $data["usuario_id"] ?? '';
$tiempo = $data["tiempo"] ?? '';

if (empty($usuario_id)) {
    echo json_encode(["status" => "error", "msg" => "ID vacío"]);
    exit;
}

$stmt = $conn->prepare("UPDATE usuarios SET tiempo = ? WHERE id = ?");
$stmt->bind_param("ii", $tiempo, $usuario_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "msg" => "Tiempo actualizado"]);
} else {
    echo json_encode(["status" => "error", "msg" => "No se actualizó ningún registro"]);
}

$stmt->close();
$conn->close();
?>
