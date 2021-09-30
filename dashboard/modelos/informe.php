<?php include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
//recepcion de los datos enviados mediante POST

$id_informe = (isset($_POST['id_informe'])) ? $_POST['id_informe'] :'';
$nombre = (isset($_POST['nombre']))? $_POST['nombre'] :'';
$opcion = (isset($_POST['opcion']))? $_POST['opcion'] : '';



/* $id_informe = (isset($_POST['id_informe'])) ? $_POST['id_informe'] :'';
$nombre = (isset($_POST['nombre']))? $_POST['nombre'] :'';
$opcion = (isset($_POST['opcion']))? $_POST['opcion'] : ''; */


?>