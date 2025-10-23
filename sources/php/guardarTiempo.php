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

try{            
    $stmt = $conexion->prepare("UPDATE usuario SET tiempo = ? WHERE u_idUsuario = ?");
    $stmt->execute([$tiempo, $usuario_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "success", "msg" => "Tiempo actualizado"]);
    } else {
        echo json_encode(["status" => "error", "msg" => "No se actualizó ningún registro"]);
    }
}catch(PDOException $e){
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}
?>
