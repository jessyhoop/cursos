<!DOCTYPE html>
<html lang="es" >
    <head>
        <?php
        include('head.php');
        ?>
        <script src="<?php echo base_url() ?>/assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
        <style>
            /*//elementos para el icono que carga datos*/
            .loader {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
                display: none;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <header>
            <?php
            include('header.php');
            ?>
        </header>
        <section class="section-admin-test my-10">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12  text-center align-items-center">
                        <h2 class="gray">Inscripci&oacute;n a Cursos</h2>

                    </div>
                    <div class="col-sm-12 text-left  align-items-center">
                        <h5 class="gray"><strong>Bienvenido Alumno:
                            </strong><?php echo $this->session->userdata('nombre_completo'); ?></h5>

                    </div>
                </div>

                <div class="row md-12 ">
                    <form  class="text-left col-12 col-sm-12" id="formulario_inscripcion"  method="POST" name="formulario_inscripcion">
                        <div class="form-row ">
                            <div class="col-10 col-sm-10">
                                <label for=lista_de_cursos>Lista de cursos</label>
                                <select class="form-control" name="lista_de_cursos" id="lista_de_cursos">
                                </select>                                            </div>
                            <div class="col-2 col-sm-2" >
                                <button class="btn btn-info my-4 btn-block waves-effect waves-light" type="submit">Inscribir</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-left align-items-left flex-column">
                                <h4 class="gray">Descripci&oacute;n del curso</h4>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datos_curso" cellspacing="0" class="table
                                   " style="width:100%">
                            <!--<table class="table text-center" id="datos_curso">-->
                                <thead class="thead-light">
                                    <tr>
                                        </th>
                                        <th class="th-sm">Turno </th>
                                        <th class="th-sm">Curso </th>
                                        <th class="th-sm">Carrera </th>
                                        <th class="th-sm">Profesor</th>
                                        <th class="th-sm">Fecha Inicio</th>
                                        <th class="th-sm">Fecha Fin</th>
                                        <th class="th-sm">Hora Inicio</th>
                                        <th class="th-sm">Hora Fin</th>
                                        <th class="th-sm">Cupo</th>
                                        <th class="th-sm">Lugares Disponibles</th>
                                    </tr>
                                </thead>
                                <tbody id="show_datos_curso">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-left align-items-left flex-column">
                        <h4 class="gray">Mis Cursos inscritos</h4>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="table-responsive">
                        <table id="datos_cursos_inscritos" cellspacing="0" class="table
                               "
                               style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    </th>
                                    <th class="th-sm">Turno </th>
                                    <th class="th-sm">Curso </th>
                                    <th class="th-sm">Carrera </th>
                                    <th class="th-sm">Profesor</th>
                                    <th class="th-sm">Fecha Inicio</th>
                                    <th class="th-sm">Fecha Fin</th>
                                    <th class="th-sm">Hora Inicio</th>
                                    <th class="th-sm">Hora Fin</th>
                                    <th class="th-sm" colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_datos_cursos_inscritos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group col-12 text-center mt-3">
                    <!--<a href="<?php echo base_url(); ?>index.php/Reportes_generales" class="btn btn-primary "><i class="fas fa-arrow-left"></i> Regresar a Reportes Generales</a>-->
                    <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">Finalizar <i class="fas fa-sign-out-alt"></i></a>
                    <i class="fa fa-question-circle-o"></i>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <?php
        include('footer.php');
        ?>
    </footer>
</body>
<script  src="<?php echo base_url(); ?>/js/controlador_alumno.js"></script>
</html>