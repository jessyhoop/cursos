
<!DOCTYPE html>
<html lang="es" >
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/nuevoStyle.css" media="all"/> </head>
    <!--<script type="text/javascript" src="<?php // echo base_url();                ?>/assets/jquery-2.1.3.js"></script>-->
    <!--SCRIPTS PARA SWEET-ALERT-->
    <script src="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert-dev.js"></script><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert.css"> 
    <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
    <!--SCRIPTS PARA CALENDARIO-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

    <?php
    include('head.php');
    ?>

    <style>
        .table-wrapper-scroll-y {
display: block;
max-height: 300px;
overflow-y: auto;
-ms-overflow-style: -ms-autohiding-scrollbar;
}
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
        include('header_user_adm_evaluaciones.php');
        ?>
    </header>
    <section>
        <div class="section-admin-users my-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Administraci&oacute;n de  Materias</h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMate ">
                            A&ntilde;adir materia
                        </button>
                        <button  class="btn btn-primary" id="muestra_lista_de_materias">Mostrar lista de materias</button>
                    </div>
                </div>
  <div class="row mt-5">
                    <div class="col-12">
                        <table class="table table-bordered table-striped     text-center" >
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" >Clave <br>Materia</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                           
                        </table>
                    </div>
                </div>
                <div class="table-wrapper-scroll-y">
                <div class="row mt-4">
                    <div class="col-12">
                        <table class="table table-bordered table-striped     text-center" id="list_profesores">
                         
                            <tbody id="show_datos_materias">
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-12 text-center mt-3">
                        <a href="<?php echo base_url(); ?>index.php/Evaluaciones" class="btn btn-primary "> <i class="fas fa-arrow-left"></i>  Menu</a>
                        <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">Finalizar  <i class="fas fa-sign-out-alt"></i></a>
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
    <!-- MODAL PARA AÑADIR DATOS DE MATERIA -->
    <div class="modal fade" id="addMate" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >A&ntilde;adir Materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario_materia"  method="POST" name="formulario_materia">

                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="clave_materia">Clave Materia:</label>
                                    <input  required="required" type="text" class="form-control" name="clave_materia"  placeholder="Clave de materia">
                                </div>
                                <div class="form-group">
                                    <label for="nombre_materia">Nombre:</label>
                                    <input  required="required" required="required" name="nombre_materia" class="form-control"   placeholder="Nombre de la materia">
                                </div>
                                <div class="form-group">
                                    <label for="semestre_materia">Semestre:</label>
                                    <input  required="required" required="required" name="semestre_materia" class="form-control"   placeholder="">
                                </div>
                                

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!--TERMINA EL MODAL PARA AÑADIR A UNA MATERIA--> 
    <!-- ==============================     ==========MODAL PARA LA EDICION DE DATOS===============================
        =====================================================================================================-->
    <div class="modal fade" id="editMateria" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Editar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario_materia_edit"  method="POST" name="formulario_materia_edit">

                        <div class="form-row">  
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="clave_materia_edit">Clave Materia:</label>
                                    <input required="required" type="text" class="form-control" name="clave_materia_edit" >
                                </div>
                                <div class="form-group">
                                    <label for="nombre_materia_edit">Nombre:</label>
                                    <input required="required" required="required" name="nombre_materia_edit" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="semestre_materia_edit">Semestre:</label>
                                    <input required="required" required="required" name="semestre_materia_edit" class="form-control" >
                                </div>
                              

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--CIERRE DE MODAL PARA LA EDICION DE DATOS--> 
</body>
<script src="<?php echo base_url(); ?>/js/controlador_form.js" type="text/javascript"></script>
<!------------link para mostrar y ocultar las contrasenias-->
<script src="<?php echo base_url(); ?>assets/show/bootstrap-show-password.js"></script>
<!--<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />-->	
<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


</html>
