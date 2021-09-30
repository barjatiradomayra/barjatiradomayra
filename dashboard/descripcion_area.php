<?php require_once "paginas/parte_superior.php"?>

<!--INICIO del cont principal-->
<?php
// include_once '../bd/conexion.php';
// $objeto = new Conexion();
// $conexion = $objeto->Conectar();

$id_area = $_GET['id_area'];

$consulta_area = "SELECT nombre_area FROM area Where id_area = '$id_area'";
$resultado_area = $conexion->prepare($consulta_area);
$resultado_area->execute();
$datos_area = $resultado_area->fetch(PDO::FETCH_ASSOC);


$consulta = "SELECT id_descripcion,titulo,descripcion FROM descripcion_area WHERE id_area = '$id_area' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>


<b><h2 class="ml-5">Descripcion del Area:</b> <?php echo $datos_area['nombre_area']?></h2><br>
<div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo_d_areas" type="button" class="btn btn-success" data-toggle="modal">Nueva descripcion</button>    
            </div>    
        </div>    
</div>    
<br>  
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">        
                <table id="tabla_desc_areas" class="table table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>Id</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <tr>
                        <td><?php echo $dat['id_descripcion'] ?></td>
                        <td><?php echo $dat['titulo'] ?></td>
                        <td><?php echo $dat['descripcion'] ?></td>
                        <td></td>
                    </tr>
                    <?php
                        }
                    ?>                                
                </tbody>        
                </table>                    
            </div>
        </div>
    </div>  
</div>    

<!--Modal para CRUD-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formDesArea" enctype="multipart/form-data" onsubmit="return false">    
            <div class="modal-body">
                <div class="form-group">
                <label for="id_area" class="col-form-label">AREA:</label>
                <span class="form-control"><?php echo $datos_area['nombre_area']?></span>
                <input type="hidden" class="form-control" id="id_area" value="<?php echo $id_area?>">
                </div>
                <div class="form-group">
                <label for="titulo" class="col-form-label">Titulo:</label>
                <input type="text" class="form-control" id="titulo">
                </div>                
                <div class="form-group">
                <label for="descripcion" class="col-form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion">
                <label for="imagen_area" class="col-form-label">Imagen_area</label>
                <input type="file" class="form-control-file" id="imagen_area" accept="image/x-png,image/gif,image/jpg">
                
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  

<!--FIN del cont principal-->
<?php require_once "paginas/parte_inferior.php"?>
