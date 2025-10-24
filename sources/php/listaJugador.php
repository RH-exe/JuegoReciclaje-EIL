<?php 
    header("Content-Type: application/json; charset= utf-8");
    require_once "conexion.php";

    $data = json_decode(file_get_contents("php://input"));
    $area = $data["area"] ?? null;

    if(empty($area)){
        echo json_encode(["error" => "Area no encontrada"]);
    }

    

?>