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
                            <a style="text-decoration: none"  href="<?php echo base_url() ?>index.php/admin_reportes_generales/reporte_por_curso_view">
 <i class="fas fa-file-pdf"></i>&nbsp;Reporte por Curso
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo base_url()
            ?>index.php/admin_reportes_generales/reporte_por_division_view">
                                 <i class="fas fa-file-pdf"></i>&nbsp;Reporte por Divisi&oacute;n</a>

                        </li>
                        <li class="list-group-item">

                            <a href="<?php echo base_url()
            ?>index.php/admin_reportes_generales/reporte_por_asistencia_view">
                                <i class="fas fa-file-pdf"></i>&nbsp;Reporte por Asistencia</a>
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
