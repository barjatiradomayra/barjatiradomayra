<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

/*los id que se reciben deben ir siempre al inicio*/
$id_meta = (isset($_POST['id_meta'])) ? $_POST['id_meta'] : '';

$fecha_actual = (isset($_POST['fecha_actual'])) ? $_POST['fecha_actual'] : '';

$cantidad_ejecutado = (isset($_POST['cantidad_ejecutado'])) ? $_POST['cantidad_ejecutado'] : '';
$estado_ejecucion = 1;
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$porcentaje_completo = (isset($_POST['porcentaje_completo'])) ? $_POST['porcentaje_completo'] : '';

$id_ejecucion = (isset($_POST['id_ejecucion'])) ? $_POST['id_ejecucion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO ejecucion (fecha_actual, cantidad_ejecutado, porcentaje_completo, estado_ejecucion, id_meta) VALUES('$fecha_actual', '$cantidad_ejecutado', '$porcentaje_completo', '$estado_ejecucion', '$id_meta') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_ejecucion, fecha_actual, cantidad_ejecutado, porcentaje_completo, estado_ejecucion FROM ejecucion ORDER BY id_ejecucion DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE ejecucion SET fecha_actual='$fecha_actual', cantidad_ejecutado='$cantidad_ejecutado', porcentaje_completo='$porcentaje_completo' WHERE id_ejecucion='$id_ejecucion' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_ejecucion, fecha_actual, cantidad_ejecutado, porcentaje_completo FROM ejecucion WHERE id_ejecucion='$id_ejecucion' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;  

    case 3://baja
        $consulta = "DELETE FROM ejecucion WHERE id_ejecucion='$id_ejecucion' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id_ejecucion, fecha_actual, cantidad_ejecutado FROM ejecucion ORDER BY id_ejecucion DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;  
}


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
?>