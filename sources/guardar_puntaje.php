<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$usuario_id = $data["usuario_id"] ?? '';
$puntaje = $data["puntaje"] ?? 0;
$nivel = $data["nivel"] ?? 0;

if (!$usuario_id) {
    echo json_encode(["status" => "error", "msg" => "No hay jugador"]);
    exit;
}

try {
    // Verificar si ya existe un registro para ese usuario
    $sql = "SELECT * FROM usuario WHERE u_idUsuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([":id" => $usuario_id]);

    if ($stmt->rowCount() > 0) {
        // Actualiza el puntaje (como texto)
        $sqlUpdate = "UPDATE usuario SET puntaje = :puntaje WHERE u_idUsuario = :id";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':puntaje' => strval($puntaje), // 👈 fuerza el valor a string
            ':id' => $usuario_id
        ]);
        echo json_encode(["status" => "ok", "msg" => "Puntaje actualizado"]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Usuario no encontrado"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}