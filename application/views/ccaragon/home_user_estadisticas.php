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
        <section>

            <div class="section-actions my-5">

                <div class="container">
                    <div class="row">

                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="orange">Promedio de Cursos por profesor</h2>
                            <p align="center">
                                Visualiza la grafica de los promedios obtenidos de cada materia por profesor.
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/Estadistica_de_promedios_por_curso_por_profesor"><img width="50%" class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/estadistica.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/Estadiscas_por_profesor_en_grafica_por_anio"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/grafico-circular.svg" alt=""></a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="pink">Cantidad de cursos por profesor</h2>
                            <p>
                                Visualiza la grafica de la cantidad de cursos por profesor.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-12 text-center mt-4">
                        <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">
                            <i class="fas fa-sign-out-alt"></i> Finalizar</a>                        <i class="fa fa-question-circle-o"></i>
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
