<?php
    header('content-type: application/json');
    include ("conexion.php");
    
    try{
        $sql="SELECT u_Area, SUM(p_Nivel1 + p_Nivel2) AS total 
        from usuario group BY u_Area"; 

        $stmt = $conexion->prepare($sql);
        $stmt ->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $areas = [];
        foreach($resultado as $row){
            $areas[$row['u_Area']] = (int)$row['total'];
        }

        echo json_encode($areas);

    }catch(PDOException $e){
        echo json_encode(['error' => $e->getMessage()]);
    }
?>