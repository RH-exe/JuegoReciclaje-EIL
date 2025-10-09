<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$usuario_id = $data["usuario_id"] ?? '';
$puntaje = $data["puntaje"] ?? 0;
$nivel = $data["nivel"] ?? 0;

if (!$usuario_id) {
    echo json_encode(["status" => "error", "msg" => "Usuario no válido"]);
    exit;
}

try {
    // Verificar si ya existe un registro para ese usuario
    $sql = "SELECT * FROM usuario WHERE u_idUsuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([":id" => $usuario_id]);
    $existe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existe) {
        // Si existe, actualizar la columna del nivel
        if ($nivel == 1) {
            $sql = "UPDATE usuario
                    SET p_Nivel1 = :puntaje
                    WHERE u_idUsuario = :id";
        } else {
            $sql = "UPDATE usuario 
                    SET p_Nivel2 = :puntaje
                    WHERE u_idUsuario = :id";
        }
        $stmt = $conexion->prepare($sql);
        $stmt->execute([":puntaje" => $puntaje, ":id" => $usuario_id]);

        echo json_encode(["status" => "ok", "msg" => "Puntaje actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "msg" => "usuraio no encontrado"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}
?>
