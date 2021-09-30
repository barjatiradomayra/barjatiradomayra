<?php require_once "paginas/parte_superior.php"?>
<!--INICIO del cont principal-->
<?php
// include_once '../bd/conexion.php';
// $objeto = new Conexion();
// $conexion = $objeto->Conectar();

$id_area = $_GET['id_area'];

$consulta_area = "SELECT nombre_area FROM area Where id_area='$id_area'";
$resultado_area = $conexion->prepare($consulta_area);
$resultado_area->execute();
$datos_area = $resultado_area->fetchAll(PDO::FETCH_COLUMN);

$consulta = "SELECT id_meta, descripcion, unidad_medida, cantidad, gestion, periodo_meta FROM meta Where id_area='$id_area'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="d-flex justify-content-center"><b>Area: <?php echo $datos_area[0];?></b></h2>

<h3 class="ml-5">Listado De Metas</h3>
<div class="container">

        <div class="row">
            <div class="col-lg-12"> 
                <!--btnnueva JS-->           
            <button id="btnnueva_meta" type="button" class="btn btn-success" data-toggle="modal">Nueva Meta</button>    
            </div>    
        </div>    
</div>    
<br>  
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive"> 
                   
                <!--tabla_ JS-->    
                <table id="tabla_meta" class="table table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Unidad Medida</th>                          
                        <th>Cantidad</th> 
                        <th>Gestion</th>
                        <th>Periodo</th> 
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <tr>
                        <td><?php echo $dat['id_meta'] ?></td>
                        <td><?php echo $dat['descripcion'] ?></td>
                        <td><?php echo $dat['unidad_medida'] ?></td>
                        <td><?php echo $dat['cantidad'] ?></td>
                        <td><?php echo $dat['gestion'] ?></td>
                        <td><?php echo $dat['periodo_meta'] ?></td>     
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--form_ JS-->
        <form id="form_meta">    
            <div class="modal-body">
                <div class="form-group">
                <label for="descripcion" class="col-form-label">Descripcion Meta:</label>
                <input type="text" class="form-control" id="descripcion">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_prestamo">unidad de medida</label>
                            <input id="unidad_medida" class="form-control" type="text" name="fecha_prestamo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_devolucion">cantidad</label>
                            <input id="cantidad" class="form-control" type="number" name="fecha_devolucion">
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_prestamo">gestion</label>
                            <input id="gestion" class="form-control" type="number" name="fecha_prestamo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="rol">Periodo</label>
                            <select id="periodo_meta" class="form-control" name="rol">
                                <option value="Anual">Anual</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Mensual">Mensual</option>
                            </select>
                    </div>
                    <input type="hidden" value="<?php echo $id_area;?>" id="id_area">
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