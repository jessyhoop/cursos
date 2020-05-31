    
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
    <!--script para table--> 
    <?php
    include('head.php');
    ?>
</head>
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
        include('header.php');
        ?>
    </header>
    <section>
        <div class="section-admin-users my-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="gray">Administraci&oacute;n de Cursos</h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-" data-toggle="modal" 
                                data-target="#addUser">
                            A&ntilde;adir Curso
                        </button>
                        <button  class="btn btn-primary" id="muestra_lista_de_cursos">Mostrar lista de cursos</button>
                        <!--<button  class="btn btn-primary" id="muestra_lista_de_cursos_inactivas">Mostrar lista de cursos</button>-->
                    </div>
                </div>
                <!----------------------------L I S T A   D E   C U R S O S------------------------------->

                <div class="dataTables_wrapper pt-4 ">
                    <table id="list_cursos" cellspacing="0" class="table
                           " style="width:100%">
                    <!--<table class="table text-center" id="list_cursos">-->
                        <thead class="thead-dark">
                            <tr>
                                </th>
                                <th class="th-sm">Turno </th>
                                <th class="th-sm">Curso </th>
                                <th class="th-sm">Carrera </th>
                                <th class="th-sm">Profesor</th>
                                <th class="th-sm">Fecha Inicio</th>
                                <th class="th-sm">Fecha Fin</th>
                                <th class="th-sm">Hora Inicio</th>
                                <th class="th-sm">Hora Fin</th>
                                <th class="th-sm">Cupo</th>
                                <th class="th-sm" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="show_datos_cursos">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-12 text-center mt-3">
                        <a href="<?php echo base_url(); ?>index.php/Cursos" class="btn btn-primary ">Menu</a>
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
    <!-----------------M O D A L   P A R A    A N A D I R   C U R S O SS---------------------> 

    <div class="modal fade" id="addUser" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >A&ntilde;adir Curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario_curso"  method="POST" name="formulario_curso">

                        <div class="form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="turno">Turno:</label>
                                    <!--<input required="required" type="text" class="form-control" name="turno_curso"  placeholder="Grupo">-->
                                    <select class="custom-select" name="turno_curso" id="turno_curso">
                                        <option class="custom-select" disabled selected>Elige un turno </option>
                                        <option value="Matutino"> Matutino</option>
                                        <option value="Vespertino">Vespertino </option>
                                        <option value="VespertinoOnline">VespertinoOnline </option>
                                        <option value="MatutinoOnline">MatutinoOnline </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="curso_curso" >Nombre del curso:</label>
                                    <input required="required"
                                           class="form-control" 
                                           name="curso_curso"
                                           type="text"/>    
                                </div>
                                <div class="form-group">
                                    <label for="cupo_curso" >Cupo del curso:</label>
                                    <input required="required"
                                           class="form-control" 
                                           name="cupo_curso"
                                           type="number"/>    
                                </div>
                                <div class="form-group">
                                    <label>Carrera:</label>
                                    <select class="custom-select" name="carrera_id_curso" id="carrera_id_curso">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Fecha Inicio:</label>
                                    <input required="required"
                                           class="form-control calendario_fecha" 
                                           name="fecha_inicio_curso"
                                           type="date"/>    
                                </div>
                                <div class="form-group">
                                    <label >Fecha Fin :</label>
                                    <input required="required"
                                           name="fecha_fin_curso" 
                                           type="date"
                                           class="form-control calendario_fecha"  
                                           >
                                </div>
                                <div class="form-group">
                                    <label>Hora Inicio  :</label>
                                    <input required="required"  
                                           class="form-control"
                                           type="time"
                                           name="hora_inicio_curso"
                                           value="00:00:00" 
                                           max="22:30:00" min="01:00:00" step="1">
                                </div>
                                <div class="form-group">
                                    <label >Hora Fin  :</label>
                                    <input required="required"  class="form-control" type="time" name="hora_fin_curso" value="00:00:00" max="22:30:00" min="01:00:00" step="1">
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

 ========================================MODAL PARA LA EDICION DE DATOS===============================
    =====================================================================================================-->
<div class="modal fade" id="editEval" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Editar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario_curso_edit"  method="POST" name="formulario_curso_edit">
                    <div class="modal-body">
                        <form id="formulario_curso"  method="POST" name="formulario_curso">

                            <div class="form-row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="turno_curso_edit">Turno:</label>
                                        <!--<input required="required" type="text" class="form-control" name="turno_curso"  placeholder="Grupo">-->
                                        <select class="custom-select" name="turno_curso_edit" id="turno_curso_edit">
                                            <option class="custom-select" disabled selected>Elige un turno </option>
                                            <option value="Matutino"> Matutino</option>
                                            <option value="Vespertino">Vespertino </option>
                                            <option value="VespertinoOnline">VespertinoOnline </option>
                                            <option value="MatutinoOnline">MatutinoOnline </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="curso_curso_edit" >Nombre del curso:</label>
                                        <input required="required"
                                               class="form-control" 
                                               name="curso_curso_edit"
                                               type="text"/>    
                                    </div>
                                    <div class="form-group">
                                        <label for="cupo_curso_edit" >Cupo del curso:</label>
                                        <input required="required"
                                               class="form-control" 
                                               name="cupo_curso_edit"
                                               type="number"/>    


                                    </div>

                                    <div class="form-group">
                                        <label for="carrera_id_curso_edit">Carrera:</label>
                                        <select class="custom-select" name="carrera_id_curso_edit" id="carrera_id_curso_edit">

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label >Fecha Inicio:</label>
                                        <input required="required"
                                               class="form-control calendario_fecha" 
                                               name="fecha_inicio_curso_edit"
                                               type="date"/>    


                                    </div>
                                    <div class="form-group">
                                        <label >Fecha Fin :</label>
                                        <input required="required"
                                               name="fecha_fin_curso_edit" 
                                               type="date"
                                               class="form-control calendario_fecha"  
                                               >
                                    </div>
                                    <div class="form-group">
                                        <label>Hora Inicio  :</label>
                                        <input required="required"  
                                               class="form-control"
                                               type="time"
                                               name="hora_inicio_curso_edit"
                                               value="00:00:00" 
                                               max="22:30:00" min="01:00:00" step="1">
                                    </div>
                                    <div class="form-group">
                                        <label >Hora Fin  :</label>
                                        <input required="required"  class="form-control" type="time" 
                                               name="hora_fin_curso_edit" value="00:00:00" max="22:30:00" min="01:00:00" step="1">
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
</body>
<script src="<?php echo base_url(); ?>/js/controlador_cursos.js" type="text/javascript"></script>
<!------------link para mostrar y ocultar las contrasenias-->
<script src="<?php echo base_url(); ?>assets/show/bootstrap-show-password.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />	
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


</html>
