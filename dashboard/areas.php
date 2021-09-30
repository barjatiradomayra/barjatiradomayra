<?php require_once "paginas/parte_superior.php"?>

<!--INICIO del cont principal-->
    <h1>LISTADO DE AREAS</h1>
    <?php
// include_once '../bd/conexion.php';
// $objeto = new Conexion();
// $conexion = $objeto->Conectar();
if($tipo_user!="Administrador"){
    $consulta = "SELECT id_area, nombre_area, responsable, cantidad_personal FROM area Where id_usuario='$id_usuario'";
}
else{
    $consulta = "SELECT id_area, nombre_area, responsable, cantidad_personal FROM area";
}
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>
<?php if($tipo_user!="Administrador"){
    
    if(sizeof($data)<1){
    
    ?>
<div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnnueva_area" type="button" class="btn btn-success" data-toggle="modal">Nueva Area</button>    
            </div>    
        </div>    
</div> 
<?php  }} ?>
<br>  
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">        
                <table id="tabla_area" class="table table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE AREA</th>
                        <th>RESPONSABLE</th>                                
                        <th>CANTIDAD PERSONAL</th>  
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <tr>
                        <td><?php echo $dat['id_area'] ?></td>
                        <td><?php echo $dat['nombre_area'] ?></td>
                        <td><?php echo $dat['responsable'] ?></td>
                        <td><?php echo $dat['cantidad_personal'] ?></td>    
                        <td>
                            <a href="metas.php?id_area=<?php echo $dat['id_area'] ?>" class="btn btn-success">metas</a>
                            <button class='btn btn-primary btnEditar_area'>Editar</button>
                            <button class='btn btn-danger btnBorrar_area'>Borrar</button>
                        </td>
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
        <form id="form_area">    
            <div class="modal-body">
                <div class="form-group">
                <input id="id_usuarioa"  type="hidden" value="<?php echo $id_usuario; ?>">
                <label for="nombre_area" class="col-form-label">Nombre Area:</label>
                <input type="text" class="form-control" id="nombre_area">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_prestamo">Responsable:</label>
                            <input readonly id="responsable" class="form-control" type="text" value="<?php echo $nombre_user; ?>">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_devolucion">Cantidad Personal:</label>
                            <input id="cantidad_personal" class="form-control" type="number" name="fecha_devolucion">
                        </div>
                    </div>
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