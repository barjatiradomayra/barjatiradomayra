<?php require_once "paginas/parte_superior.php"?>
<!--INICIO del cont principal-->
    
<?php
// include_once '../bd/conexion.php';
// $objeto = new Conexion();
// $conexion = $objeto->Conectar();

$id_meta = (isset($_GET['id_meta'])) ? $_GET['id_meta'] : '';

$consulta_meta = "SELECT descripcion, cantidad FROM meta Where id_meta='$id_meta'";
$resultado_meta = $conexion->prepare($consulta_meta);
$resultado_meta->execute();
$datos_meta = $resultado_meta->fetch(PDO::FETCH_ASSOC);

$consulta = "SELECT id_ejecucion, fecha_actual, cantidad_ejecutado, porcentaje_completo FROM ejecucion WHERE id_meta='$id_meta'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="d-flex ml-5">
    <b>
    <?php 
        
            echo "Meta: ".$datos_meta['descripcion']."<br>"; 
            echo "<h3>Cantidad: ".$datos_meta['cantidad']."</h3>";
    ?>
    </b>
</h2>

<div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnnueva_ejecucion" type="button" class="btn btn-success" data-toggle="modal">Nueva ejecucion</button>    
            </div>    
        </div>    
</div>    
<br>  
<h3 class="ml-5">Listado de Ejecuciones</h3>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">        
                <table id="tabla_ejecucion" class="table table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>FECHA ACTUAL</th>
                        <th>CANTIDAD EJECUTADA</th>
                        <th>PORCENTAJE EJECUTADO</th>  
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <tr>
                        <td><?php echo $dat['id_ejecucion'] ?></td>
                        <td><?php echo $dat['fecha_actual'] ?></td>
                        <td><?php echo $dat['cantidad_ejecutado'] ?></td> 
                        <td><?php echo $dat['porcentaje_completo']?> %</td>   
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

        <form id="form_ejecucion">    
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_prestamo">fecha actual:</label>
                            <input id="fecha_actual" class="form-control" type="date" name="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_prestamo">Cantidad ejecutada:</label>
                            <input id="cantidad_ejecutado" oninput="calcular()" class="form-control" type="number">
                        </div>
                    </div>

                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_devolucion">Porcentaje:</label>
                            <input id="porcentaje_completo" class="form-control" type="text" disabled>
                        </div>
                    </div>
                </div> 

                <div class="alert alert-danger" role="alert" id="alert_no"></div>

                <input type="hidden" value="<?php echo $id_meta;?>" id="id_meta">   

                <!--*************************************************************-->
                <input type="hidden" value="" id="suma_ejecutado">
                <input type="hidden" value="<?php echo $datos_meta['cantidad']; ?>" id="meta_cantidad">

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

<script>

function calcular(){
	try{
        
		let cantidad = <?php echo $datos_meta['cantidad']; ?>,
		cantidad_ejecutado = parseFloat(document.getElementById("cantidad_ejecutado").value) || 0;

		document.getElementById("porcentaje_completo").value = ((cantidad_ejecutado/cantidad)*100).toFixed(2)+" %";
		
	}catch (e){}
}

</script>