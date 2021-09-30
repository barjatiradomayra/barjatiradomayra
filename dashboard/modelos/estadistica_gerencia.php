<?php 

include_once '../../bd/conexion.php';

$area=$_POST['area'];
$objeto = new Conexion();
$conexion = $objeto->Conectar();
    // $consulta = "SELECT id_meta, descripcion, unidad_medida, cantidad, gestion, periodo_meta FROM meta";
    $consulta = "SELECT  meta.cantidad as cantidad_meta , meta.descripcion as descripcion, SUM(ejecucion.cantidad_ejecutado) as cantidad_ejecutado,TRUNCATE(SUM(ejecucion.porcentaje_completo),0) as porcentaje FROM meta LEFT JOIN ejecucion on meta.id_meta=ejecucion.id_meta RiGHT JOIN area on meta.id_area=area.id_area WHERE area.id_area='$area' GROUP BY ejecucion.id_meta ORDER BY ejecucion.id_meta desc LIMIT 5";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll();	
    $arreglo_metas = array();
    foreach($data as $dat) { 
            $arreglo_metas[] = $dat;
        }
echo json_encode($arreglo_metas);	



?>