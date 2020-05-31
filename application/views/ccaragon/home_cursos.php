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
                            <h2 >Administraci&oacute;n de Cursos</h2>
                            <p align="center">
                                Da de alta y baja, o realiza cambios y consultas de cursos.</p>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <!--<a href="<?php echo base_url() ?>index.php/Estadistica_de_promedios_por_curso_por_profesor"><img width="50%" class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/estadistica.svg" alt=""></a>-->
                            <a href="<?php echo base_url() ?>index.php/Cursos/cursos_view"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/evaluacion.svg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-12 text-center mt-3">
                            <?php if ($this->session->userdata('tipo_user') == 1) { ?>
                                <a href="<?php echo base_url(); ?>index.php/Login" class="btn btn-primary "> <i class="fas fa-arrow-left"></i>  Regresar</a>
                            <?php } else {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/Login" class="btn btn-primary "> <i class="fas fa-arrow-left"></i>  Regresar</a>
                                <?php
                            }
                            ?>
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
