<html lang="es" >
    <head>
        <?php
        $this->load->view('ccaragon/head.php');
        ?>
        <script src="<?php echo base_url(); ?>assets/plugins/package/dist/sweetalert2.all.js" type="text/javascript"></script>
    </head>
    <header>
        <?php
        $this->load->view('ccaragon/header.php');
        ?>
    </header>
    <body>

        <section height="300px">
            <div class="section-actions my-5">
                <div class="container">        
                    <div class="container box">
                        <h3 align="center">
                            csv alumnos
                        </h3>
                        <br />

            <form method="post" id="import_csv" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select CSV File</label>
                    <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
                </div>
                <br />
                <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Importar CSV</button>
            </form>
            <br />
            <div id="imported_csv_data"></div>
        </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-12 text-center mt-3">
                            <a href="<?php echo base_url(); ?>index.php/admin_csv" class="btn btn-primary "> <i class="fas fa-arrow-left"></i>  Regresar</a>
                            <a href="<?php echo base_url(); ?>index.php/Login/adminLogOut" class="btn btn-primary ">
                                Finalizar &nbsp;<i class="fas fa-sign-out-alt"></i> </a>                        <i class="fa fa-question-circle-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script  src="<?php echo base_url(); ?>/js/csv/controlador_alumno_carrera.js"></script>
</html>
