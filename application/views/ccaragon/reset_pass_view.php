<!DOCTYPE html>
<html lang="es" >
    <head>
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
    <header>

        <?php
        include('header.php');
        ?>
    </header>
    <body>
        <div class="container my-4">
            <section id="register-form">
                <div class="row">
                    <div class="col-md-12 " id="password_view_confirmar">
                        <section>
                            <form  class="text-left border border-secondary p-5  " 
                                   id="formulario_usuario"  method="POST" name="formulario_usuario">
                                <h1 class="text-center">Confirma usuario
                                </h1>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="correo_usuario">Correo Institucional:</label>
                                            <input pattern = 
                                                   "^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$"
                                                   required="required" name="correo_usuario" type="email"
                                                   class="form-control"   placeholder="Correo electronico">
                                        </div>
                                        <div class="form-row mb-4">

                                            <div class="col">
                                                <label for="numcuenta_usuario">N&uacute;mero de Cuenta/ N&uacute;mero de trabajador:
                                                </label>
                                                <input required="required" type="text"
                                                       class="form-control" name="numcuenta_usuario"
                                                       placeholder="N&uacute;mero de Cuenta"
                                                       minlength="6"
                                                       maxlength="9">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-info my-4 btn-block waves-effect waves-light" type="submit">Enviar</button>
                            <a href="<?php echo base_url(); ?>index.php/Login/"
                                   class="btn btn-secondary my-4 btn-block">Login </a>

                            </form>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div id="edit_password" class="col-md-12 " style="display: none">
                        <section>
                            <form  class="text-left border border-secondary p-5  "  id="form_edit_password"  method="POST" name="form_edit_password">
                                <h1 class="text-center">  Cambiar contrase&ntilde;a
                                </h1>
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
                                                <label for="passwd_usuario_edit">
                                                    Repita la contrase&ntilde;a :<small>8 caracteres</small></label>
                                                <input required="required" type="password" 
                                                       name="passwd_usuario_edit" 
                                                       class="form-control"  
                                                       placeholder="Repite la contrase&ntilde;a anterior
                                                       "
                                                       maxlength="8"
                                                       minlength="8">
                                            </div> 

                                            </span>
                                        </div>
                                <button class="btn btn-info my-4 btn-block waves-effect waves-light" type="submit">Enviar</button>
                            <a href="<?php echo base_url(); ?>index.php/Login/"
                                   class="btn btn-secondary my-4 btn-block">Cancelar </a>

                            </form>
                        </section>
                    </div>
                </div>
            </section>
        </div>
        <footer>
            <?php
            include('footer.php');
            ?>

        </footer>

    </body>
    <script src="<?php echo base_url(); ?>assets/show/bootstrap-show-password.js"></script>
    <script  src="<?php echo base_url(); ?>/js/controlador_reset_passwd.js"></script>
    <!--SCRIPTS PARA SWEET-ALERT-->
    <script src="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert-dev.js"></script><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert.css"> 
    <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>

</html>
