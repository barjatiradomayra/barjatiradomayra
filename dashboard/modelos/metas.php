<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
/*debe existir un id_area para poder insertar una meta*/

// Recepción de los datos enviados mediante POST desde el JS   

/*los id que se reciben deben ir siempre al inicio*/
$id_area = (isset($_POST['id_area'])) ? $_POST['id_area'] : '';

$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$unidad_medida = (isset($_POST['unidad_medida'])) ? $_POST['unidad_medida'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$gestion = (isset($_POST['gestion'])) ? $_POST['gestion'] : '';
$periodo_meta = (isset($_POST['periodo_meta'])) ? $_POST['periodo_meta'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_meta = (isset($_POST['id_meta'])) ? $_POST['id_meta'] : '';
$estado_meta = 1;




switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO meta (descripcion, unidad_medida, cantidad, gestion, periodo_meta, estado_meta, id_area) VALUES('$descripcion', '$unidad_medida', '$cantidad', '$gestion', '$periodo_meta', '$estado_meta', '$id_area') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_meta, descripcion, unidad_medida, cantidad, gestion, periodo_meta FROM meta ORDER BY id_meta DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 2: //modificación
        $consulta = "UPDATE meta SET descripcion='$descripcion', unidad_medida='$unidad_medida', cantidad='$cantidad', gestion='$gestion', periodo_meta='$periodo_meta' WHERE id_meta='$id_meta' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();     
        
        $consulta = "SELECT id_meta, descripcion, unidad_medida, cantidad, gestion, periodo_meta FROM meta WHERE id_meta='$id_meta' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;  
              
    case 3://baja
        $consulta = "DELETE FROM meta WHERE id_meta='$id_meta' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id_meta, descripcion, unidad_medida, cantidad, gestion, periodo_meta FROM meta ORDER BY id_meta DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
