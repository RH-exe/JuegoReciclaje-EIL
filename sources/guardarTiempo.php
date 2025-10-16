<?php
    header("Content-Type: application/json; charset=utf-8");
    require_once "conexion.php";

    $data = json_decode(file_get_contents("php://input"),true);

    $usuario_id = $data["usuario_id"] ?? 0;
    $tiempo = $data["tiempo"] ?? 0;

    if(!$usuario_id){
        echo json_encode(["status" => "error", "msg" => "no hay jugador"]);
        exit;
    }

    try{
        $sql = "UPDATE usuario SET tiempo = :tiempo WHERE u_idUsuario = :id";
        $stmt = $conexion->prepare($sql);
        $stmt ->execute([":tiempo"=> $tiempo, ":id" => $usuario_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "success", "msg" => "Tiempo actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "warning", "msg" => "No se actualizó ningún registro"]);
        }
    }catch(PDOException $e){
        echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
    }
?>