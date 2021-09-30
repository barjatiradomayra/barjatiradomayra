<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$id_area = (isset($_POST['id_area'])) ? $_POST['id_area'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_descripcion = (isset($_POST['id_descripcion'])) ? $_POST['id_descripcion'] : '';
$imagen = (isset($_FILES["f"]["name"])) ? $_FILES["f"]["name"] : '';
date_default_timezone_set('America/La_Paz');
$fecha=getdate();
$nombre_f=$fecha["mday"]."-".$fecha["mon"]."-".$fecha["year"]."_".$fecha["hours"]."-".$fecha["minutes"]."-".$fecha["seconds"].".jpg";

// $imagen="user";
switch($opcion){
    case 1: //alta
        if(move_uploaded_file($_FILES["f"]["tmp_name"],"img_areas/".$nombre_f)){
            $consulta = "INSERT INTO descripcion_area (titulo, descripcion, imagen_area, id_area) VALUES('$titulo', '$descripcion', '$nombre_f','$id_area') ";			
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(); 
            
            $consulta = "SELECT id_descripcion,titulo,descripcion FROM descripcion_area ORDER BY id_descripcion DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            break;
        }

    case 2: //modificación
        $consulta = "UPDATE descripcion_area SET titulo='$titulo', descripcion='$descripcion', imagen_area='$imagen' id_area='$id_area' WHERE id_descripcion='$id_descripcion' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_descripcion,titulo,descripcion FROM  descripcion_area WHERE id_descripcion='$id_descripcion' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM descripcion_area WHERE id_descripcion='$id_descripcion' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id_descripcion,titulo,descripcion FROM descripcion_area ORDER BY id_descripcion DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
