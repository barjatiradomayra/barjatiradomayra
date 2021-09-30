<?php
session_start();

include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


//recepción de datos enviados mediante POST desde ajax
if(isset($_POST['usuario'])){
    $usuario = $_POST['usuario'];

}else{
    $usuario = '';
}
//$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

$pass = md5($password); //encripto la clave enviada por el usuario para compararla con la clava encriptada y almacenada en la BD//sha1 cambio de md5






$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$pass' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if($resultado->rowCount() >= 1){//tiene que ser = 1 osea un usuario
    $data = $resultado->fetch(PDO::FETCH_ASSOC);
    $_SESSION["s_usuario"] = $usuario;
    
}else{
    $_SESSION["s_usuario"] = null;
    $data=null;
}

print json_encode($data);
$conexion=null;

//usuarios de pruebaen la base de datos
//usuario:admin pass:12345
//usuario:demo pass:demo