<?php
header("content-type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);
$usuario_id = $data["usuario_id"]??'';

if(!$usuario_id){
    echo json_encode(["status" => "error", "msg" => "usuario no valido"]);
    exit;
}

try{
    $sql = "SELECT u_nombre AS nombre,
                SUM(p_Nivel1 + p_Nivel2) as 'puntaje_total' from usuario where u_idUsuario = :id GROUP BY u_nombre;";
    $stmt= $conexion->prepare($sql);
    $stmt->execute([":id" => $usuario_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        echo json_encode(["status" => "ok", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Usuario no encontrado"]);
    }

}catch ( PDOException $e){
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}
?>