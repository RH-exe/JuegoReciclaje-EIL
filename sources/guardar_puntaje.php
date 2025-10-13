<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$usuario_id = $data["usuario_id"] ?? '';
$puntaje = $data["puntaje"] ?? 0;
$nivel = $data["nivel"] ?? 0;

if (!$usuario_id) {
    respuesta("error", "Usuraio no valido");
    exit;
}

function respuesta($status, $msg, $data = null){
    $response = ["status" => $status, "msg"=>$msg];
    if($data !== null) $response["data"] =$data;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
//guradar puntaje o actualizar
function GuardarPuntaje($conexion,$usuario_id, $puntaje, $nivel){
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

        } else {
            respuesta("error", "Usuario no encontrado");
        }
    } catch (PDOException $e) {
        respuesta("error", $e->getMessage());
    }
}
//mostra puntaje por usuario
function PuntajeTotal($conexion,$usuario_id){
    try{
        $sql = "SELECT u_nombre as nombre, 
                SUM(p_Nivel1 + p_Nivel2) as 'puntaje total' 
                from usuario where u_idUsuario = :id GROUP BY u_nombre;";
        $stm= $conexion->prepare($sql);
        $stm->execute([":id" => $usuario_id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    } catch( PDOException $e){
        respuesta("error", $e->getMessage());
    }
}

GuardarPuntaje($conexion, $usuario_id, $puntaje,$nivel);

$datos= PuntajeTotal($conexion, $usuario_id);
respuesta("ok", "puntaje actualizado correctamente", $datos);

?>
