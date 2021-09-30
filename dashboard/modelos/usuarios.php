<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

$nombre_user = (isset($_POST['nombre_user'])) ? $_POST['nombre_user'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$tipo_user = (isset($_POST['tipo_user'])) ? $_POST['tipo_user'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$pass="827ccb0eea8a706c4c34a16891f84e7b";
switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO usuarios (nombre_user, usuario, password, tipo_user) VALUES('$nombre_user', '$usuario', '$pass','$tipo_user') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id, nombre_user, usuario, tipo_user FROM usuarios ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE usuarios SET nombre_user='$nombre_user', usuario='$usuario', tipo_user='$tipo_user' WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id, nombre_user, usuario, tipo_user FROM usuarios WHERE id='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM usuarios WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id, nombre_user, usuario, tipo_user FROM usuarios ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
