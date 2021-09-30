<?php
include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$id_meta = (isset($_POST['id_meta'])) ? $_POST['id_meta'] : '';

$ejecucion = "SELECT meta.cantidad as cantidad_meta ,SUM(ejecucion.cantidad_ejecutado) as cantidad_ejecutado,(meta.cantidad-SUM(ejecucion.cantidad_ejecutado)) as cantidad_restante ,SUM(ejecucion.porcentaje_completo) as porcentaje_ejecutado FROM ejecucion INNER JOIN meta on meta.id_meta=ejecucion.id_meta WHERE meta.id_meta='$id_meta' GROUP BY ejecucion.id_meta";
$resultado_ejecucion = $conexion->prepare($ejecucion);
$resultado_ejecucion->execute();
$datos_eje = $resultado_ejecucion->fetch(PDO::FETCH_ASSOC);

/*devolvemos este dato al ajax*/
$sum_ejecucion = $datos_eje["cantidad_ejecutado"];
$restante=$datos_eje["cantidad_restante"];
$porcentaje=$datos_eje["porcentaje_ejecutado"];
$msg="No puede sobrepasar la Cantidad de la Meta!!! La cantidad restante es: ".$restante;
$datos = array($sum_ejecucion, $msg, $porcentaje);
echo json_encode($datos);

$conexion = NULL;
?>