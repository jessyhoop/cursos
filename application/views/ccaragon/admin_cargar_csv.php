<!DOCTYPE html>
<html lang="es" >
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/nuevoStyle.css" media="all"/> </head>
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
        //include('header_user_adm.php');
        ?>
    </header>
    <section>
        <div class="section-admin-users my-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Cargar datos csv</h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
						<form method="post" action="importar_csv" enctype="multipart/form-data">
                        <div class="custom-file">
							<input type="file" class="custom-file-input" name="csv_file" id="customFile" required accept=".csv">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<button type="submit" name="importar_csv" class="btn btn-info" id="importar_csv">Importar</button>
						</form>
                    </div>
                </div>
				
				<div class="row mt-5">
					<div id="datos_importados"></div>
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
	
	<script> 
		$(document).ready(function(){
			
			cargar_datos();
			
			function cargar_datos(){
				$.ajax({
					url:"<?php echo base_url();?>index.php/importar_csv/cargar_datos",
					method:"POST", 
					success:function(data){
						$('#datos_importados').html(data);
					}
				});
			}
			
			$('#importar_csv').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url:"<?php echo base_url(); ?>index.php/importar_csv/importar";
				});
			});
		});
	
	</script>
    
</body>