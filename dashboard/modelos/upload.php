<?php 

// Requerimientos de clases externas
require_once 'vendor/autoload.php'; // requerimos el autoloader para cargar todo lo que necesitemos de las librerías de composer
use Verot\Upload\Upload; // es obligatorio usar el namespace para poder cargar la clase con éxito

/**
 * Genera redirección entre rutas
 *
 * @param string $url
 * @return void
 */
function redirect($url) {
  header(sprintf('Location: %s', $url));
  die;
}

///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
//                    LÓGICA DEL PROCESO
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

// Validamos la existencia del parametro con el archivo
if (!isset($_FILES['file'])) {
  redirect('index.php?error=no-image');
}

$file = $_FILES['file']; // archivo temporal en espera de ser procesado
$path = 'uploads/';      // donde vamos a guardar el archivo

$foo  = new Upload($file);

if (!$foo) {
  redirect('index.php?error=no-uploaded'); // La imagen no se ha subido correctamente, vuelve a intentarlo
}

// save uploaded image with no changes
$foo->process($path);
if ($foo->processed) {
  echo 'Guardamos la imagen original con éxito.<br>';
} else {
  echo sprintf('Error: %s<br>', $foo->error);
}

// Nueva versión reducida
$size_x                  = 500;
$foo->file_new_name_body = sprintf('%spx_%s', $size_x, time());
$foo->image_resize       = true;
$foo->image_x            = $size_x;
$foo->image_ratio        = true; // para conservar las proporciones
$foo->process($path);
if ($foo->processed) {
	$foo->clean();
  echo sprintf('Imagen redimensionada a %s px con éxito.<br>', $size_x);
} else {
  echo sprintf('Error: %s<br>', $foo->error);
} 

echo 'Proceso finalizado';



<?php
include_once '../../bd/conexion.php';

// Requerimientos de clases externas
require_once 'vendor/autoload.php'; // requerimos el autoloader para cargar todo lo que necesitemos de las librerías de composer
use Verot\Upload\Upload; // es obligatorio usar el namespace para poder cargar la clase con éxito

/**
 * Genera redirección entre rutas
 *
 * @param string $url
 */
$file = $_FILES['f']; // archivo temporal en espera de ser procesado
$path = 'img_areas/';      // donde vamos a guardar el archivo

$foo  = new Upload($file);


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
$nombre_f=$fecha["mday"]."-".$fecha["mon"]."-".$fecha["year"]."_".$fecha["hours"]."-".$fecha["minutes"]."-".$fecha["seconds"];

$size_x                  = 900;
$foo->file_new_name_body = $nombre_f;
$foo->image_resize       = true;
$foo->image_x            = $size_x;
$foo->image_ratio        = true; // para conservar las proporciones
$foo->process($path);
if ($foo->processed) {
	$foo->clean();
//   echo sprintf('Imagen redimensionada a %s px con éxito.<br>', $size_x);
} 
// $imagen="user";
switch($opcion){
    case 1: //alta
        if($foo->processed){
            $consulta = "INSERT INTO descripcion_area (titulo, descripcion, imagen_area, id_area) VALUES('$titulo', '$descripcion', '$nombre_f".".jpg"."','$id_area') ";			
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(); 
            
            $consulta = "SELECT id_descripcion,titulo,descripcion FROM descripcion_area ORDER BY id_descripcion DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            $foo->clean();
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
