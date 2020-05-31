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
                    <ul class="list-group">

                        <li class="list-group-item">
                            <a href="<?php echo base_url()
            ?>index.php/admin_csv/csv_alumno">
                                <i class="far fa-file-excel"></i>&nbsp;Carga de archivo CSV de alumnos</a>

                        </li>
                        <li class="list-group-item">

                            <a href="<?php echo base_url()
            ?>index.php/admin_csv/csv_alumno_carrera">
                                <i class="far fa-file-excel"></i>&nbsp;Carga de archivo CSV de alumno relacionado con carrera</a>
                        </li>

                        <li class="list-group-item">
                            <a href="<?php echo base_url()
            ?>index.php/admin_csv/csv_alumno_curso">
                                <i class="far fa-file-excel"></i>&nbsp;Carga de archivo CSV de alumno relacionado a cursos</a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo base_url()
            ?>index.php/admin_csv/csv_cursos">
                                <i class="far fa-file-excel"></i>&nbsp;Carga CSV cursos</a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo base_url()
            ?>index.php/admin_csv/csv_profesores">
                                <i class="far fa-file-excel"></i>&nbsp;Carga CSV profesor</a>
                        </li>
                    </ul>



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
