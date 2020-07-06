<!DOCTYPE html>
<html lang="es" >
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/nuevoStyle.css" media="all"/> </head>
    <!--SCRIPTS PARA CALENDARIO-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

    <?php
    include('head.php');
    ?>

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
        include('header.php');
        ?>
    </header>
    <section>
        <div class="section-admin-users my-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Administraci&oacute;n de Alumnos</h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser">
                            A&ntilde;adir Alumno
                        </button>
                        <button  class="btn btn-primary" 
                                 id="muestra_lista_alumnos">Lista de alumnos</button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 table-responsive">
                        <table id="tabla_alumnos" class="table  tabla_alumnos">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">RFC</th>
                                    <th scope="col">Num.Centa/<br/>Trabajador</th>
                                    <th scope="col">Correo Electronico</th>
                                    <th scope="col">Carrera1</th>
                                    <th scope="col">Carrera2</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-12 text-center mt-3">
                        <a href="<?php echo base_url(); ?>index.php/Login/home_user_adm" class="btn btn-primary ">Menu</a>
                        <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">Finalizar</a>
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
    <!-- MODAL PARA AÑADIR DATOS DE USURIOS -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >A&ntilde;adir alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class=""  id="formulario_usuario"  method="POST" name="formulario_usuario">
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="usuario">Nombre:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="nombre_usuario"
                                           placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="apellidop_usuario">Apellido Paterno:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="apellidop_usuario"
                                           placeholder="Apellido Paterno">
                                </div>
                                <div class="form-group">
                                    <label for="apellidom_usuario">Apellido Materno:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="apellidom_usuario"
                                           placeholder="Apellido Materno">
                                </div>
                                <div class="form-group">
                                    <label for="correo_usuario">Correo Electronico:</label>
                                    <input required="required" name="correo_usuario" type="email"
                                           class="form-control"   placeholder="Correo electronico">
                                </div>
                                <div class="form-group">
                                    <label for="carrera1">Carrera1:</label>
                                    <select id="carrera1" class="carreras custom-select" name="carrera1">

                                    </select>
                                </div>
                                <div class="form-group">
                                    Segunda carrera: <input  class="otraCarrera" type="checkbox" value=1
                                                             name="otraCarrera" />
                                </div>
                                <div class="form-group carreraOpt">
                                    <label for="carrera">Carrera2:</label>
                                    <select id="carrera2" class="carreras custom-select " name="carrera2">

                                    </select>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="col">
                                        <label for="rfc_usuario">RFC:</label><small>13 caracteres</small>
                                        <input required="required" type="text"
                                               class="form-control" name="rfc_usuario"
                                               placeholder="RFC"
                                               maxlength="13"
                                               minlength="13"
                                               >
                                    </div>
                                    <div class="col">
                                        <label for="numcuenta_usuario">N&uacute;mero de Cuenta/Trabajador:
                                        </label>
                                        <input required="required" type="text"
                                               class="form-control" name="numcuenta_usuario"
                                               placeholder="N&uacute;mero de Cuenta"
                                               minlength="6"
                                               maxlength="9">
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class=" col">
                                        <label for="passwd_usuario">Contrase&ntilde;a :</label><small>8 caracteres</small>
                                        <input data-attr="show-password"required="required" 
                                               type="password" name="passwd_usuario"
                                               class="form-control"  
                                               placeholder="Ingresa la nueva contrase&ntilde;a"
                                               maxlength="8"
                                               minlength="8">

                                        <span class="focus-input100"></span>
                                    </div>
                                    <div class=" col">
                                        <label for="passwd_usuario_confirm">
                                            Repita la contrase&ntilde;a :<small>8 caracteres</small></label>
                                        <input required="required" type="password" 
                                               name="passwd_usuario_confirm" 
                                               class="form-control"  
                                               placeholder="Repite la contrase&ntilde;a anterior
                                               "
                                               maxlength="8"
                                               minlength="8">
                                    </div> 
                                    </span>
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

    <!--TERMINA EL MODAL PARA AN ADIR A UN NUEVO USUARIO--> 
    <!-- ========================================MODAL PARA LA EDICION DE DATOS===============================
        =====================================================================================================-->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Editar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class=""  id="formulario_usuario_edit"  method="POST" name="formulario_usuario_edit">
                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_usuario_edit">Nombre:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="nombre_usuario_edit"
                                           placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="apellidop_usuario_edit">Apellido Paterno:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="apellidop_usuario_edit"
                                           placeholder="Apellido Paterno">
                                </div>
                                <div class="form-group">
                                    <label for="apellidom_usuario_edit">Apellido Materno:</label>
                                    <input required="required" type="text"
                                           class="form-control" name="apellidom_usuario_edit"
                                           placeholder="Apellido Materno">
                                </div>
                                <div class="form-group">
                                    <label for="correo_usuario_edit">Correo Institucional:</label>
                                    <input
                                           required="required" name="correo_usuario_edit" type="email"
                                           class="form-control"   placeholder="Correo electronico">
                                </div>
                                 <div class="form-group">
                                    <label for="carrera1_edit">Carrera1:</label>
                                    <select id="carrera1_edit" class="carreras custom-select" name="carrera1_edit">

                                    </select>
                                </div>
                                <div class="form-group">
                                    Segunda carrera: <input  class="otraCarrera" type="checkbox" value=1
                                                             name="otraCarrera" />
                                </div>
                                <div class="form-group carreraOpt">
                                    <label for="carrera2_edit">Carrera2:</label>
                                    <select id="carrera2_edit" class="carreras custom-select " name="carrera2_edit">

                                    </select>
                                </div>
                               
                                <div class="form-row mb-4">
                                    <div class="col">
                                        <label for="rfc_usuario_edit">RFC:</label><small>13 caracteres</small>
                                        <input required="required" type="text"
                                               class="form-control" name="rfc_usuario_edit"
                                               placeholder="RFC"
                                               maxlength="13"
                                               minlength="13"
                                               >
                                    </div>
                                    <div class="col">
                                        <label for="numcuenta_usuario_edit">N&uacute;mero de Cuenta/
                                            Trabajador:</label>
                                        <input required="required" type="text"
                                               class="form-control" name="numcuenta_usuario_edit"
                                               placeholder="N&uacute;mero de Cuenta"
                                               minlength="6"
                                               maxlength="9">
                                    </div>
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


    <!-- ========================================MODAL PARA LA EDICION DE CONTRASE�AS===============================
        =====================================================================================================-->
    <div class="modal fade" id="editUserPasswd" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Cambiar Contrase&ntilde;a</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario_usuario_edit_passwd"  method="POST" name="formulario_usuario_edit_passwd">

                        <div class="form-row">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <label for="passwd_usuario_edit">Contrase&ntilde;a nueva:</label>
                                    <input  minlength="8" maxlength="8" data-attr="show-password"required="required"
                                            type="password" name="passwd_usuario_edit" class="form-control"   placeholder="Ingresa la nueva contrase&ntilde;a [8 CARACTERES]">
                                    <span class="focus-input100"></span>
                                </div>


                                <div class="form-group">
                                    <label for="passwd_usuario_edit_confirm">Repita la contrase&ntilde;a  nueva:</label>
                                    <input   minlength="8" maxlength="8" required="required" type="password"  name="passwd_usuario_edit_confirm" class="form-control"  placeholder="Repite la contrase&ntilde;a anterior">
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
</body>
<script src="<?php echo base_url(); ?>/js/controlador_admin_alumno.js" type="text/javascript"></script>
<!------------link para mostrar y ocultar las contrasenias-->
<script src="<?php echo base_url(); ?>assets/show/bootstrap-show-password.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</html>
