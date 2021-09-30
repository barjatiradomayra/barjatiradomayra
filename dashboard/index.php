<?php require_once "paginas/parte_superior.php"?>


<div class="container">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">SISTEMA GERENCIAL-ELAPAS</h1>
    
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
<!-- Content Row -->


<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->


<?php if($tipo_user !="Gerente" && $tipo_user !="Administrador"){ ?>
<!-- Se mostrara este grafico solo a mayra(encargado) ya que es diferente con administrador y gerente-->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div    
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Metas Ejecutaadas</h6><!--Ejecutar cambio de planilla-->
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div> -->
                </div>
            </div>

            <!-- <button class="btn btn-danger" onclick="datos()">Mostrar datos</button> -->
            <?php 
                $consulta = "SELECT id_area, nombre_area  FROM area where id_usuario='$id_usuario'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                
            ?>
            <form id="FormSelectArea">
                <input type="hidden" id="id_usuario" value="<?php echo $id_usuario; ?>">
                <input type="hidden" id="tipo_usuario" value="<?php echo $tipo_usuario; ?>">
                <div class="d-flex flex-row justify-content-center alig-items-center">
                <select class="form-control col-sm-6" onchange="mostrarGrafico(this.value);" name="area" id="selectArea">
                <?php                            
                    foreach($data as $dat) {                                                        
                    ?>
                    <option  value="<?php echo $dat['id_area']; ?>"><?php echo $dat['nombre_area'];  ?></option>
                    <?php
                        }
                    ?>   
                </select>
                </div>
            </form>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area" style="width:100%; height: 40vh; margin:0">
                    <!-- ------------------------------- -->
                    <canvas id="myBarChart"></canvas>
                    <!-- ------------------------------- -->
                </div>
            </div>
        </div>
    </div>
<?php }?>

<!-- Aqui termina mi estadistica de BARRAS -->



  <?php  
#inicio de la otra tabla#
    $consulta_m = "SELECT * FROM `area` WHERE id_usuario=$id_usuario";
    $resultado_m = $conexion->prepare($consulta_m);
    $resultado_m->execute();
    $datos_m = $resultado_m->fetch(PDO::FETCH_ASSOC);
    $id_ar=isset($datos_m['id_area']) ? $datos_m['id_area']:"";

    $consulta_metas = "SELECT meta.cantidad as cantidad_meta , meta.descripcion as descripcion, SUM(ejecucion.cantidad_ejecutado) as cantidad_ejecutado,TRUNCATE(SUM(ejecucion.porcentaje_completo),0) as porcentaje FROM meta LEFT JOIN ejecucion on meta.id_meta=ejecucion.id_meta RIGHT JOIN area on meta.id_area=area.id_area WHERE area.id_area='$id_ar' GROUP BY ejecucion.id_meta ORDER BY ejecucion.id_meta desc LIMIT 5";
    $resultado_metas = $conexion->prepare($consulta_metas);
    $resultado_metas->execute();
    $metas_ = $resultado_metas->fetchAll(PDO::FETCH_ASSOC);
    $porcentaje=array();
    $descrip=array();
    foreach ($metas_ as $m) {
       
        array_push($porcentaje,$m['porcentaje']);
        array_push($descrip,$m['descripcion']);
    }
    $area1=isset($datos_m['nombre_area']) ? $datos_m['nombre_area']:"";
    $met1=isset($descrip[0]) ? $descrip[0]:"";
    $met2=isset($descrip[1]) ? $descrip[1]:"";
    $met3=isset($descrip[2]) ? $descrip[2]:"";
    $met4=isset($descrip[3]) ? $descrip[3]:"";
    $met5=isset($descrip[4]) ? $descrip[4]:"";
    $pcj1=isset($porcentaje[0]) ? $porcentaje[0]:0;
    $pcj2=isset($porcentaje[1]) ? $porcentaje[1]:0;
    $pcj3=isset($porcentaje[2]) ? $porcentaje[2]:0;
    $pcj4=isset($porcentaje[3]) ? $porcentaje[3]:0;
    $pcj5=isset($porcentaje[4]) ? $porcentaje[4]:0;

    
    ?> 
<?php if($tipo_user !="Gerente" && $tipo_user !="Administrador"){ ?>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div 
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">PORCENTAJE DE METAS  <?php echo $area1; ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
            <h4 class="small font-weight-bold"><?php echo $met1; ?> <span class="float-right"><?php echo $pcj1; ?> %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $pcj1; ?>%"
                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met2; ?> <span
                        class="float-right"><?php echo $pcj2; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pcj2; ?>%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met3; ?> <span
                        class="float-right"><?php echo $pcj3; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $pcj3; ?>%"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met4; ?> <span
                        class="float-right"><?php echo $pcj4; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $pcj4; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met5; ?> <span
                        class="float-right"><?php echo $pcj5;?>%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $pcj5; ?>%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<!-- /.container-fluid -->

<?php if($tipo_user=="Gerente" || $tipo_user=="Administrador"){ ?>
    
<?php 
        $consulta_area = "SELECT id_area, nombre_area  FROM area";
        $resultado_area = $conexion->prepare($consulta_area);
        $resultado_area->execute();
        $data_area = $resultado_area->fetchAll(PDO::FETCH_ASSOC);
?>



<div>
<form id="FormSelectarea">
    <div class="d-flex flex-row justify-content-center alig-items-center">
    <select class="form-control col-sm-6" onchange="mostrar(this.value);" name="area" id="select_area_1">
   
    <?php                            
        foreach($data_area as $dat) {                                                        
        ?>
        <option  value="<?php echo $dat['id_area']; ?>"><?php echo $dat['nombre_area'];  ?></option>
        <?php
            }
        ?>  
    </select>
    </div>
</form>
</div>

<div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div 
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">PORCENTAJE DE METAS><?php echo $dat['nombre_area'];?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
            <h4 class="small font-weight-bold"><?php echo $met1; ?> <span class="float-right"><?php echo $pcj1; ?> %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $pcj1; ?>%"
                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met2; ?> <span
                        class="float-right"><?php echo $pcj2; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pcj2; ?>%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met3; ?> <span
                        class="float-right"><?php echo $pcj3; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $pcj3; ?>%"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met4; ?> <span
                        class="float-right"><?php echo $pcj4; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $pcj4; ?>%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold"><?php echo $met5; ?> <span
                        class="float-right"><?php echo $pcj5;?>%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $pcj5; ?>%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }?>


<!--FIN del cont principal-->

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<!-- <script src="js/demo/chart-area-demo.js"></script> -->
<script src="js/demo/chart-bar-demo.js"></script>
<!-- <script src="js/demo/chart-pie-demo.js"></script> -->

<script>



</script>
<?php require_once "paginas/parte_inferior.php"?>
<!-- 
<script type="text/javascript" src="js/estadisticas.js"></script>  -->
<script type="text/javascript" src="js/porcentaje.js"></script>