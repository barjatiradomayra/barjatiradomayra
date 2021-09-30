<?php require_once "paginas/parte_superior.php"?>

<!--INICIO del cont principal-->

    <h1>LISTA DE USUARIOS</h1>
 <?php
// include_once '../bd/conexion.php';
// $objeto = new Conexion();
// $conexion = $objeto->Conectar();

$consulta = "SELECT id, nombre_user, usuario, tipo_user FROM usuarios";

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo_user" type="button" class="btn btn-success" data-toggle="modal">Nuevo Usuario</button>    
            </div>    
        </div>    
</div>    
<br>  
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">        
                <table id="tabla_usuarios" class="table table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>USUARIO</th>                                
                        <th>TIPO DE USUARIO</th>  
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <tr>
                        <td><?php echo $dat['id'] ?></td>
                        <td><?php echo $dat['nombre_user'] ?></td>
                        <td><?php echo $dat['usuario'] ?></td>
                        <td><?php echo $dat['tipo_user'] ?></td>    
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
            <form id="formUsuarios">    
            <div class="modal-body">
                <div class="form-group">
                <label for="nombre_user" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre_user">
                </div>
                <div class="form-group">
                <label for="usuario" class="col-form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario">
                </div>                
                <div class="form-group">
                <label for="tipo_user" class="col-form-label">Tipo de usuario:</label>
                <!-- <input type="text" class="form-control" id="tipo_user"> -->
                <select class="form-control" name="tipo_user" id="tipo_user">
                    <option value="administrador">Administrador</option>
                    <option value="encargado">Encargado</option>
                </select>
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
