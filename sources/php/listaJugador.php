<?php 
    header("Content-Type: application/json; charset=utf-8");
    require_once "conexion.php";

    $data = json_decode(file_get_contents("php://input"));
    $area = $data -> area ?? null;

    if(empty($area)){
        echo json_encode(["error" => "Area no encontrada"]);
        exit;
    }
    
    try{
        $sql = "SELECT u_nombre, puntaje, u_Area from usuario where u_Area = :area;";
        $stmt = $conexion->prepare($sql);
        $stmt -> bindParam(":area", $area);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }catch(PDOException $e){
        echo json_encode(["error" => $e->getMessage()]);
    }
?>