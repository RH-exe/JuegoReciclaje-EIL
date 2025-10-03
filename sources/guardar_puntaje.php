<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$usuario_id = $data["usuario_id"] ?? null;
$puntaje = $data["puntaje"] ?? 0;
$nivel = $data["nivel"] ?? 1;

if (!$usuario_id) {
    echo json_encode(["status" => "error", "msg" => "Usuario no válido"]);
    exit;
}

try {
    // Verificar si ya existe un registro para ese usuario
    $sql = "SELECT * FROM usuario WHERE U_idUsuario = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([":id" => $usuario_id]);
    $existe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existe) {
        // Si existe, actualizar la columna del nivel
        if ($nivel == 1) {
            $sql = "UPDATE usuario
                    SET p_Nivel1 = :puntaje, p_fecha = NOW() 
                    WHERE U_idUsuario = :id";
        } else {
            $sql = "UPDATE usuario 
                    SET p_Nivel2 = :puntaje, p_fecha = NOW() 
                    WHERE U_idUsuario = :id";
        }
        $stmt = $conexion->prepare($sql);
        $stmt->execute([":puntaje" => $puntaje, ":id" => $usuario_id]);
    } else {
        // Si no existe, insertar nuevo registro
        if ($nivel == 1) {
            $sql = "INSERT INTO usuario (U_idUsuario, p_Nivel1, p_Nivel2) 
                    VALUES (:id, :puntaje, 0)";
        } else {
            $sql = "INSERT INTO usuario (U_idUsuario, p_Nivel1, p_Nivel2) 
                    VALUES (:id, 0, :puntaje)";
        }
        $stmt = $conexion->prepare($sql);
        $stmt->execute([":id" => $usuario_id, ":puntaje" => $puntaje]);
    }

    echo json_encode(["status" => "ok"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}
?>
