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
                    <div class="row p-3 mb-2 bg-light">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="gray">Administraci&oacute;n de Usuarios</h2>
                            <p>
                                Da de alta, baja, o realiza cambios y consultas de profesores/Alumnos.
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/Admin_usuarios"><img width="50%" class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/user_solid.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="row p-3 mb-2 bg-light">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a
                                href="<?php echo base_url()
                                ?>index.php/admin_reportes_generales/">
                                <img class="icons-seleccion" 
                                     src="<?php echo base_url(); ?>images/icons/clipboard-list-solid.svg" alt=""></a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="ocre">Administraci&oacute;n de Reportes</h2>
                            <p>
                               Consultas de reportes.
                            </p>
                        </div>
                    </div>
                    <div class="row p-3 mb-2 bg-light">
                        <div  height="300px"   class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="blue">Administraci&oacute;n de Cursos</h2>
                            <p>
                                Da de alta, baja, o realiza cambios y consultas de cursos.
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/Admin_cursos"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/chalkboard-teacher-solid.svg" alt=""></a>
                        </div>
                    </div>
                    
                    <div class="row p-3 mb-2 bg-light">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <a href="<?php echo base_url() ?>index.php/admin_csv/"><img class="icons-seleccion" src="<?php echo base_url(); ?>images/icons/csv.svg" alt=""></a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column">
                            <h2 class="text-success">Importar archivos CSV</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-12 text-center mt-3">
                        <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">
                            Finalizar <i class="fas fa-sign-out-alt"></i></a>
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
</html>
