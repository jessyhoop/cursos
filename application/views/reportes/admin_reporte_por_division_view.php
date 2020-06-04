<!DOCTYPE html>
<html lang="es" >
    <head>
        <?php
//        include('ccaragon/head.php');
        $this->load->view('ccaragon/head.php');
        ?>
        <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
        <style>
            .confirmacion{
                /*            background:#C6FFD5;
                                      border:1px solid green;*/
                color:green;
            }
            .negacion{
                color:red;
                /*            background:ref
                ;
                                  border:1px solid red;*/
            }
        </style>
    </head>
    <body>
      <header>
        <?php
        $this->load->view('ccaragon/header.php');
        ?>
      </header>
        <section class="section-admin-test my-5">
            <div class="container ">
                <div class="row ">
                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Reporte de Divisi&oacute;n</h2>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-left align-items-left flex-column">
                        <h5 class="gray"><strong></strong><?php echo $this->session->userdata('nombre_completo'); ?></h5>
                    </div>
                </div>
                <div class="row ">
                <div class="col-4">
                        <div class="form-group">
                            Per&iacute;odo:<input required="required" class="form-control calendario_fecha" id="fecha_inicio_curso" name="fecha_inicio_curso" type="date">
                        </div>
                    </div>
                    <div class="col-4  mt-4 text-right">
                        <div class="form-group">
                            <input required="required" class="form-control calendario_fecha" id="fecha_fin_curso" name="fecha_fin_curso" type="date">
                        </div>
                    </div>
                    <div class="col-2 mt-4 text-right">
                        <div class="form-group" >
                            <button  id='mostrar_datos' type="button" class="btn btn-primary">
                                Mostrar datos.
                            </button>
                        </div>
                    </div>
                    <div class="col-2 mt-4 text-right">
                        <div class="form-group" >
                            <button  id="boton_generar_reporte" type="button" class="btn btn-success">
                                Mostrar reporte
                                <i  class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Lista de Alumnos</h2>
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-12" id="tabla">
<!--                        <table class="table text-center grand-table">
                             REQUIERE  0.7 REM EN ESTILOS LA FUENTE
                            <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Nombre Completo <a href="#"><i class="fas fa-caret-down"></i></a></th>
                                    <th scope="col">N&uacute;mero de cuenta <a href="#"><i class="fas fa-caret-down"></i></a></th>
                                </tr>
                            </thead>
                            <tbody id="datos_alumnos">
                            </tbody>
                        </table>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-12 text-center mt-3">
                            <a href="<?php echo base_url(); ?>index.php/Login/home_user_adm" class="btn btn-primary ">Menu</a>
                            <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">Finalizar</a>
                            <i class="fa fa-question-circle-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <?php
            $this->load->view('ccaragon/footer.php');
//        include('footer.php');
            ?>
        </footer>
    <script  src="<?php echo base_url(); ?>js/controlador_admin_reporte_por_division.js"></script>
    </body>

</html>