<!DOCTYPE html>
<html lang="es" >
    <head>
        <?php
        $this->load->view('ccaragon/head.php');
        ?>
    <h1>
        <?php // echo $heading; ?></h1>
    <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
</head>
<body>
    <header>
        <?php
        $this->load->view('ccaragon/header.php');
        ?>
    </header>
    <section class="section-admin-test my-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                    <h2 class="gray">Reporte de Cursos</h2>
                </div>
            </div>
            <div class="row-col-sm-12 mt-5">
                <div class="col-12 text-left">
                    <div class="form-group">
                        <label for="cursos">Selecciona un Curso</label>
                        <select class="custom-select" id="cursos" name="cursos">
                        </select>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-10 d-flex justify-content-center align-items-center flex-column">
                    <h2 class="gray">Lista de Alumnos</h2>
                </div>
                <div class="col-2 text-right">
                    <div class="form-group"  >
                        <button  id="boton_generar_reporte" type="button" class="btn btn-success">
                            Mostrar reporte
                            <i  class="fas fa-file-pdf"></i>
                        </button>
                    </div>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table text-center grand-table">
                        <!-- REQUIERE  0.7 REM EN ESTILOS LA FUENTE-->
                        <thead class="thead-dark">
                            <tr>

                                <th scope="col">Nombre Completo <a href="#"><i class="fas fa-caret-down"></i></a></th>
                                <th scope="col">N&uacute;mero de cuenta <a href="#"><i class="fas fa-caret-down"></i></a></th>
                            </tr>
                        </thead>
                        <tbody id="datos_alumnos">
                        </tbody>
                    </table>
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
//        include('footer.php');
        ?>
    </footer>
</body>
<script  src="<?php echo base_url(); ?>js/controlador_admin_reporte_de_cursos.js"></script>

</html>