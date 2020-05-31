<!DOCTYPE html>
<html lang="es" >
    <head>
        <?php
        include('head.php');
        ?>
    </head>
    <body>
        <header>
            <?php
            include('header.php');
            ?>
        </header>
        <section height="300px">
            <div class="section-actions my-5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 >Administraci&oacute;n de Profesores</h2>
                            <p align="center">
                                Da de alta y baja, o realiza cambios y consultas de cursos.</p>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/admin_usuarios/profesores_view"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/profesores.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/admin_usuarios/alumnos_view"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/estudiante.svg" alt=""></a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 >Administraci&oacute;n de Alumnos</h2>
                            <p align="center">
                                Da de alta y baja, o realiza cambios y consultas de cursos.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-12 text-center mt-3">
                            <a href="<?php echo base_url(); ?>index.php/Login" class="btn btn-primary "> <i class="fas fa-arrow-left"></i>  Regresar</a>
                            <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">
                                Finalizar &nbsp;<i class="fas fa-sign-out-alt"></i> </a>                        <i class="fa fa-question-circle-o"></i>
                        </div>
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
</html>
