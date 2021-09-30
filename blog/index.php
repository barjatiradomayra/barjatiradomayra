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
 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta charset="UTF-8">
  <title>Galería</title>
  <link rel="shortcut icon" href="../dashboard/img/icon.png">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  

  <div class="container-gallery">GALERIA DE IMAGENES ELAPAS</div>
  <div class="container">

    <?php                            
        foreach($data as $dat) {                                                        
        ?>
            <div class="item">
                <img src="<?php echo '../dashboard/modelos/img_areas/'.$dat['imagen_area']; ?>" alt="" class="item-img">
                <div class="item-text">
                    <h3><?php echo $dat['titulo']; ?></h3>
                    <p><?php echo $dat['descripcion']; ?></p>
                </div>
            </div>
    <?php  } ?>


    
    
    <!-- <div class="item">
      <img src="images/img2.jpg" alt="" class="item-img">
      <div class="item-text">
        <h3>Imagen 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur.</p>
      </div>
    </div>
    
    <div class="item">
      <img src="images/img3.jpg" alt="" class="item-img">
      <div class="item-text">
        <h3>Imagen 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur.</p>
      </div>
    </div>
    
    <div class="item">
      <img src="images/img4.jpg" alt="" class="item-img">
      <div class="item-text">
        <h3>Imagen 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur.</p>
      </div>
    </div>
    
    
    <div class="item">
      <img src="images/img5.jpg" alt="" class="item-img">
      <div class="item-text">
        <h3>Imagen 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur.</p>
      </div>
    </div>
    
    <div class="item">
      <img src="images/img6.jpg" alt="" class="item-img">
      <div class="item-text">
        <h3>Imagen 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur.</p>
      </div>
    </div> -->
  </div>
  
</body>
</html>