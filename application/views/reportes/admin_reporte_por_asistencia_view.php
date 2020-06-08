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
                color:green;
            }
            .negacion{
                color:red;
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
                        <h2 class="gray">Reporte por Asistencia</h2>
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
                                Mostrar datos
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
                <div class="dataTables_wrapper pt-4 ">
                    <table id="list_cursos" cellspacing="0" class="table
                           " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="vertical-align:top" >No</th>
                                <th  style="vertical-align:top">CURSO</th>
                                <th  style="vertical-align:top">PROFESOR</th>
                                <th  style="vertical-align:top">P&Eacute;RIODO</th>
                                <th  style="vertical-align:top"> HORARIO</th>
                                <th  style="vertical-align:top"> INSCRITOS</th>
                                <th style="vertical-align:top">CURSARON</th>
                                <!--<th width='5%'>NO <br>CURSARON</th>-->
                            </tr>
                        </thead>
                        <tbody id="show_datos">
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-auto ">
                        <img id="cargando"  src="<?php echo base_url(); ?>images/icons/cargando.gif"  alt=""  >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-12 text-center mt-3">
                            <a href="<?php echo base_url(); ?>index.php/admin_reportes_generales" class="btn btn-primary ">Menu</a>
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
            ?>
        </footer>
        <script  src="<?php echo base_url(); ?>js/controlador_admin_reporte_por_asistencia.js"></script>
    </body>

</html>