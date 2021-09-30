<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   


$nombre_area = (isset($_POST['nombre_area'])) ? $_POST['nombre_area'] : '';
$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
$cantidad_personal = (isset($_POST['cantidad_personal'])) ? $_POST['cantidad_personal'] : '';
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';
$estado_area = 1;
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_area = (isset($_POST['id_area'])) ? $_POST['id_area'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO area (nombre_area, responsable, cantidad_personal,id_usuario, estado_area) VALUES('$nombre_area', '$responsable', '$cantidad_personal','$id_usuario', '$estado_area') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_area, nombre_area, responsable, cantidad_personal FROM area ORDER BY id_area DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE area SET nombre_area='$nombre_area', responsable='$responsable', cantidad_personal='$cantidad_personal' WHERE id_area='$id_area' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_area, nombre_area, responsable, cantidad_personal FROM area WHERE id_area='$id_area' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM area WHERE id_area='$id_area' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id_area, nombre_area, responsable, cantidad_personal FROM area ORDER BY id_area DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>
