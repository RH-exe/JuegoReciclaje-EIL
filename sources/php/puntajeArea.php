<?php
    header('Content-Type: application/json');
    include ("conexion.php");
    
    try{
        $sql="SELECT u_Area, 
        SUM(CASE WHEN puntaje > 0 THEN puntaje ELSE 0 END) / 
            NULLIF(COUNT(CASE WHEN puntaje > 0 THEN 1 END), 0) as promedio
        from usuario group BY u_Area;"; 

        $stmt = $conexion->prepare($sql);
        $stmt ->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $areas = [];
        foreach($resultado as $row){
            $areas[$row['u_Area']] = (int)$row['promedio'];
        }

        echo json_encode($areas);

    }catch(PDOException $e){
        echo json_encode(['error' => $e->getMessage()]);
    }
?>