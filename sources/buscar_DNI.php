<?php
 header("Content-Type: application/json; charset=utf-8");
 require_once "conexion.php";

 $data= json_decode(file_get_contents("php://input"),true);
 $usuario_id = $data["usuario_id"] ?? '';
 $dni = $data["DNI"] ?? '';

 if(empty($dni)){
    echo json_encode(["error" => "DNI no recibido"]);
    exit;
 }

 try{
    $sql = "SELECT u_DNI, u_Area from usuario where u_DNI = :dni;";
    $stmt = $conexion->prepare($sql);
    $stmt -> bindParam(":dni", $dni);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
 }catch(PDOException $e){
    echo json_encode(["error" => $e->getMessage()]);
 }

?>