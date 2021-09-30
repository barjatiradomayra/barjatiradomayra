<?php

include_once '../bd/conexion.php';

$objeto = new Conexion();
$conexion = $objeto->Conectar();
$consulta = "SELECT * FROM descripcion_area";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Elapas||Imagenes</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="shortcut icon" href="../dashboard/img/icon.png">
    <link rel="stylesheet" href="css/estilos.css">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
   
   <form action="">
       
       <h3>Seleccionar Imagen</h3>
       <input type="text" placeholder="Titulo" class="title-image">
       <img src="images/img1.jpg" class="image-select">
       <input type="button" value="Cargar Imagen" class="load-image">
       <input type="file" class="seleted">
       <input type="button" value="Cargar" class="upload">
       
   </form>
   
   <div class="shape"></div>
   
    <div class="container-gallery">
       <h2>GALERIA ELAPAS</h2>
       <!-- <input type="button" value="Mas recientes" class="btn-recient"> -->
        <div class="gallery">
        <?php                            
            foreach($data as $dat) {                                                        
        ?>
                <div><figure><img src="<?php echo '../dashboard/modelos/img_areas/'.$dat['imagen_area']; ?>"></figure>
                <div align="center"><?php echo $dat['titulo']; ?></div></div>
        <?php  } ?>
            <figure><img src="images/img2.jpg"></figure>
            <figure><img src="images/img3.jpg"></figure>
            <figure><img src="images/img4.jpg"></figure>
            <figure><img src="images/img5.jpg"></figure>
            <figure><img src="images/img6.jpg"></figure>
            <figure><img src="images/img7.jpg"></figure>
            <figure><img src="images/img8.jpg"></figure>
            <figure><img src="images/img9.jpg"></figure>
            <figure><img src="images/img2.jpg"></figure>
            <figure><img src="images/img3.jpg"></figure>
            <figure><img src="images/img4.jpg"></figure>
            <figure><img src="images/img5.jpg"></figure>
            <figure><img src="images/img6.jpg"></figure>
            <figure><img src="images/img7.jpg"></figure>
            <figure><img src="images/img8.jpg"></figure>
            <figure><img src="images/img9.jpg"></figure>
            
            
        </div>
    </div>
    
    <i class="fas fa-plus btn-show"></i>
    
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>