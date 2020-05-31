<!DOCTYPE html>
<html lang="es" >
    <head>
        <?php
        include('head.php');
        ?>
        <script src="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert-dev.js"></script><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/sweetalert-master/dist/sweetalert.css"> 
        <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <?php
            include('header.php');
            ?>
        </header>
        <section>
            <div class="section-access my-5">
                <div class="container">
                    <!--                    <div class="row justify-content-center">
                                            <div class="col-12 col-sm-8 mb-5 ">
                                                <h2 class="text-center" >  Cursos</h2>
                                            </div>
                                        </div>-->
                    <div class="row p-3">
                        <div class=" shadow p-4 mb-4 bg-white col-sm-6 rounded mx-auto p-4 border border-secondary">
                            <?php echo validation_errors(); ?>
                            <form id="formularioLogin" name="formularioLogin" method="post" action="<?php echo base_url('index.php/Login/login') ?>">
                                <div class="form-group" id="formularioLogin" name="formularioLogin" method="post">
                                    <label for="usuario">Correo Electronico:</label>
                                    <input  required="required" type="email" class="form-control"
                                            name="inp_usuario" id="inp_usuario"  placeholder="ejemplo@aragon.unam.mx">
                                </div>
                                <div class="form-group">
                                    <label for="inp_contra">Contrase&ntilde;a:</label>
                                    <input required="required" type="password"  name="inp_contra" id="inp_contra" class="form-control" aria-describedby="contrasenaAyuda" id="exampleInputPassword1" placeholder="Contrase&ntilde;a">
                                    <small id="contrasenaoAyuda" class="form-text text-muted">8 caracteres</small>
                                </div>
                                <p>
                                    <?php if (isset($mensaje)) { ?>
                                        <?php if ($mensaje != '') { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php
                                            echo $mensaje . '<br>';
                                            ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo $mensaje;
                                    }
                                } else {
                                    echo "";
                                }
                                ?> </p>

                                <button type="submit" name="enviar" class="btn btn-success ">Ingresar</button>
                                <a href="<?php echo base_url(); ?>index.php/Registrar/"
                                   class="btn btn-primary ">
                                    Registrar </a>
                                <div id="formFooter">
                                    <a class="underlineHover"
                                       href="<?php echo base_url(); ?>index.php/Reset_pass/"
                                       >Olvidaste tu Contrase&ntilde;a?</a>
                                </div>
                            </form>
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