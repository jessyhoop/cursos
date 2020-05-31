$(document).ready(function () {

//==============================F U N C I O N E S      G E N E R A L E S-------------------------
//=====================================================================================

//funcion que habilita el caledario para los formularios 
//funcion que valida que la fecha de incio sea menor a la fecha de termino
    var check_fecha_inicio_menor_que_fecha_termino = function (fecha_inicio, fecha_termino, $mensaje) {
        var confirmacion = "El intervalo de tiempo en la fecha es correcto";
        var negacion = "No coinciden las fecha";
        //muestro el span
        $mensaje.show().removeClass();
//        alert(fecha_inicio + '-' + fecha_termino);
        var fecha_inicio_split = fecha_inicio.split('-');
        var fecha_termino_split = fecha_termino.split('-');
        var fecha_inicio = new Date(fecha_inicio_split[0], fecha_inicio_split[1], fecha_inicio_split[2]).getTime();
        var fecha_termino = new Date(fecha_termino_split[0], fecha_termino_split[1], fecha_termino_split[2]).getTime();
//        alert(fecha_inicio + '-' + fecha_termino);
        if (fecha_termino <= fecha_inicio) {
            $mensaje.text(negacion).removeClass("confirmacion").addClass('negacion');
            return false;
        } else {
            $mensaje.text(confirmacion).removeClass("negacion").addClass('confirmacion');
            return true;
        }
    };
//============================================   M  A T E R I A S ---------------------------------------------
//=======================================================================================
//controlador para el modulo de materias

//funcion que almacena los datos de la nueva materia
    $("#formulario_materia").submit(function (e) {
//validamos que ningun campo venga vacio
        if ($('input[name=clave_materia]').val() !== ""
                && $('input[name=nombre_materia]').val() !== "" & $('input[name=semestre_materia]').val() !== "") {
            $datos_materia = $("#formulario_materia").serialize();
            $.ajax({
                type: "POST",
                url: "materias/insert_materia",
                data: $datos_materia,
                success:
                        function (data) {
                            if (data) {
                                swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                muestra_lista_materias_ajax();
                                $("input[name=clave_materia").val("");
                                $("input[name=nombre_materia]").val("");
                                $("input[name=semestre_materia]").val("");
                            } else {

                                swal('La materia ya existe', "click en el boton para continuar", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 

                            }
                        },
                error: function (errorThrown) {
                    alert('Error');
                    console.log(errorThrown);
                }
//
            }); // you have missed this bracket

        } else {
            swal("Todos los campos deben de estar llenos", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        return false;
    });
    //funcion que trae los datos de la base de datos con ajaz 
    function muestra_lista_materias_ajax() {
        $.ajax({
            type: "ajax",
            url: "materias/lista_materias",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                    '<td>' + data[i].clave_materia + '</td>' +
                                    '<td>' + data[i].materia + '</td>' +
                                    '<td>' + data[i].semestre + '</td>' +
                                    '<td style="text-align:center;">' +
                                    '<a data-toggle="modal" data-target="#editMateria"\n\
 href="javascript:void(0);" class="item_edit_materia" data-edit_id_materia="'
                                    + data[i].idmateria
                                    + '"data-edit_clave_mater="'
                                    + data[i].clave_materia + '"data-edit_materia="'
                                    + data[i].materia
                                    + '"data-edit_semestre="' + data[i].semestre + '">\n\
<i class="fa fa-user-edit"></i><span class="editar ml-2">Editar</span></a>' + '   ' +
                                    '<a href="javascript:void(0);" class="item_delete_materia" name="' + data[i].idmateria + '"><i class="fa fa-user-minus"></i><span class="borrar ml-2">Borrar</span></a>' +
                                    '</td>' +
                                    '</tr>';
                        }
                        $('#show_datos_materias').html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
//
        }); // you have missed this bracket

    }
//   funcion que muestra la lista de materias al hacer click al boton
    $('#muestra_lista_de_materias').on("click", function () {
        //funcion que muestra la lista de profesores
        muestra_lista_materias_ajax();
    });
//funcion que limpia los campos del formulario para ingresar datos de la materia
    $('#limpiar_form_ingre_dat_materia').on("click", function () {
        $("input[name=clave_materia").val("");
        $("input[name=nombre_materia]").val("");
        $("input[name=semestre_materia]").val("");
        id_materia = "";
    });
//funcion que limpia los campos del formulario de edicion para ingresar datos de la materia
    $('#limpiar_form_edit_ingre_dat_materia').on("click", function () {
        $("input[name=clave_materia_edit").val("");
        $("input[name=nombre_materia_edit]").val("");
        $("input[name=semestre_materia_edit]").val("");
        id_materia = "";
    });
//funcion que elimina un registro de la  base de datos con mensaje de confirmacion 
    $('#show_datos_materias').on('click', '.item_delete_materia', function () {
        const swalWithBootstrapButtons = swal.mixin({
            cancelButtonClass: 'btn btn-danger',
            confirmButtonClass: 'btn btn-success',
            buttonsStyling: false,
        })

        swalWithBootstrapButtons({
            title: '¿Estas seguro de eliminar este registro? <br>',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'No, cancelar!',
            confirmButtonText: 'Si,eliminar!',
            reverseButtons: false//invierte el sentido de los botoness
        }).then((result) => {//si si queremos eliminar entonces eliminamos y mandamos a traer el ajax que elimna el registro de la bd
            if (result.value) {
                var id_materia = $(this).attr('name'); //obtenemos el id  del registro a eliminar
                $.ajax({

                    type: "POST",
                    url: "materias/eliminar_materia",
                    data: {id_materia: id_materia},
                    success: function (data) {
//                        swal(data,"Profdesor eliminado", "succes");//mandamos el mensaje de la validacion y  lo mandamos 
                        swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        muestra_lista_materias_ajax();
                    },
                    error: function (errorThrown) {
                        alert('Error');
                        console.log(errorThrown);
                    }
//
                }); // you have missed this bracket
//                        muestra_lista_materias_ajax();

            } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                    ) {
                swalWithBootstrapButtons(
                        'Calcelado',
                        '',
                        ''
                        )
            }
        });
    });
    var id_materia = 0;
    //funcion que se pasan los datos para la edicion  del materia
    $('#show_datos_materias').on('click', '.item_edit_materia', function () {
        $("input[name=clave_materia_edit").val($(this).data('edit_clave_mater'));
        $("input[name=nombre_materia_edit]").val($(this).data('edit_materia'));
        $("input[name=semestre_materia_edit]").val($(this).data('edit_semestre'));
        id_materia = $(this).data('edit_id_materia');
    });


    $("#formulario_materia_edit").submit(function (event) {
        if ($('input[name=clave_materia_edit]').val() !== "" && $('input[name=nombre_materia_edit]').val() !== "" && $('input[name=semestre_materia_edit]').val() !== "") {

            $.ajax({
                type: "POST",
                url: "materias/update_materia",
                data: {id_materia: id_materia, nombre_materia_edit: $("input[name=nombre_materia_edit]").val(), clave_materia_edit: $("input[name=clave_materia_edit]").val(), semestre_materia_edit: $("input[name=semestre_materia_edit]").val()},
                success:
                        function (data) {
//                           
                            swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                            muestra_lista_materias_ajax(); //mostramos la lista automaticamente para ver los cambios 

                        },
                error: function (errorThrown) {
                    alert('Error');
                    console.log(errorThrown);
                }
//
            }); // you have missed this bracket

        } else {
            swal("Todos los campos deben de estar llenos", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        event.preventDefault();
    });


    //======================================= U S U A R I O S ===============================
    //===============apartado para el edicion , creación y eliminacion de usuarios====================================================================

    //funcion que almacena los datos del nuevo usuario
    $("#formulario_usuario").submit(function (e) {
//validamos que ningun campo venga vacio
        if ($('input[name=nombre_usuario]').val() !== "" &&
                $('input[name=passwd_usuario]').val() !== "" &&
                $('input[name=rol_usuario]').val() !== "" &&
                coincidePassword($("input[name=passwd_usuario]"), $("input[name=passwd_usuario_confirm]"), $('#id_pass_confirma'))) {
            $datos_usuario = $("#formulario_usuario").serialize();
            $.ajax({
                type: "POST",
                url: "usuarios/insert_usuario",
                data: $datos_usuario,
                success:
                        function (data) {
                            if (data) {
                                swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                $("#formulario_usuario")[0].reset(); //limpisr formulario
//                                $("input[name=rol_usuario]").val('');
                                muestra_lista_usuarios_ajax();
                            } else {
                                swal('El nombre de usuario ya existe', "intenta con otro nombre", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                            }
                        },
                error: function (errorThrown) {
                    alert('Error?ingresar user');
                    console.log(errorThrown);
                }
            }); // you have missed this bracket
        } else {
            swal("Todos los campos deben de estar llenos", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        return false;
    });
//   funcion que muestra la lista de usuarios al hacer click 
    $('#muestra_lista_de_usuarios').on("click", function () {
//funcion que muestra la lista de profesores
        muestra_lista_usuarios_ajax();
    });
//funcion que transforma el tipo de rol 
    function rol_texto(id_rol) {
        switch (id_rol)
        {
            case '1':
                return "ADMINISTRADOR TOTAL";
                break;
            case '2':
                return "ACCESO A EVALUACIONES ";
                break;
            case '3':
                return "ACCESO A ESTADISTICAS";
                break;
            default:
                return "NO EXISTE USUARIO"
        }
    }

    function coincidePassword($pass1, $pass2, $mensaje) {
        var confirmacion = "Las contraseñas si coinciden";
        var negacion = "No coinciden las contraseñas";
        //muestro el span
        $mensaje.show().removeClass();
        //condiciones dentro de la función
//            if (valor1 !==valor2) {
//                span.text(negacion).addClass('negacion');
//                coincidePassword();
//                return true;
//            }
//            if (valor1.length === 0 || valor1 === "") {
//                span.text(vacio).addClass('negacion');
//                return false;
//            }
//            if (valor1.length < 6 || valor1.length > 10) {
//                span.text(longitud).addClass('negacion');
//                return false;
//            }
        if ($pass1.val().length !== 0 && $pass1.val() === $pass2.val()) {
            $mensaje.text(confirmacion).removeClass("negacion").addClass('confirmacion');
            return true;
        } else
        {
            $mensaje.text(negacion).removeClass("confirmacion").addClass('negacion');
            return false;
        }
    }

//funcion que trae la lista de usuarios de la base  con ajaX
    function muestra_lista_usuarios_ajax() {
        $.ajax({
            type: "ajax",
            url: "usuarios/lista_usuarios",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                    '<td class="actions-ancors">' + data[i].nombre + '</td>' +
                                    '<td class="actions-ancors">' + data[i].usuario + '</td>' +
//                                    '<td class="actions-ancors">' + data[i].passwd + '</td>' +
                                    '<td class="actions-ancors">' + rol_texto(data[i].rol) + '</td>' +
                                    '<td class="actions-ancors" style="text-align:center;">' +
                                    '<a data-toggle="modal" data-target="#editUser" href="javascript:void(0);" \n\
                                class="item_edit" data-edit_id_user="'
                                    + data[i].idreg_usuarios
                                    + '"data-edit_nombre="'
                                    + data[i].nombre
                                    + '"data-edit_usuario="' + data[i].usuario
                                    + '"data-edit_rol="' + data[i].rol + '">\n\
                               <i class="fa fa-user-edit"></i><span class="editar ml-2">Editar</span></a>' + '  ' +
                                    '&nbsp; &nbsp;<a href="javascript:void(0);" class="item_delete" name="' + data[i].idreg_usuarios + '"><i class="fa fa-user-minus"></i><span class="borrar ml-2">Borrar</span></a>&nbsp;&nbsp;' +
                                    '<a data-toggle="modal" class="item_edit_passwd" data-target="#editUserPasswd" href="javascript:void(0);" name="' + data[i].idreg_usuarios + '"><i class="fas fa-key"></i><span class="edicion ml-2">Cambiar contrase&ntilde;a</span></a>' +
                                    '</td>' +
                                    '</tr>';
                        }
                        $('#show_data').html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
        });
    }
//funcion que elimina un registro de la  base de datos con mensaje de confirmacion 
    $('#show_data').on('click', '.item_delete', function () {
        const swalWithBootstrapButtons = swal.mixin({
            cancelButtonClass: 'btn btn-danger',
            confirmButtonClass: 'btn btn-success',
            buttonsStyling: false,
        })
        swalWithBootstrapButtons({
            title: '¿Estas seguro de eliminar este registro?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'No, cancelar!',
            confirmButtonText: 'Si,eliminar!',
            reverseButtons: false//invierte el sentido de los botoness
        }).then((result) => {//si si queremos eliminar entonces eliminamos y mandamos a traer el ajax que elimna el registro de la bd
            if (result.value) {
                var idreg_usuario = $(this).attr('name');
                $.ajax({
                    type: "POST",
                    url: "usuarios/eliminar_usuario",
                    data: {idreg_usuario: idreg_usuario},
                    success: function (data) {
//                        swal(data,"Profdesor eliminado", "succes");//mandamos el mensaje de la validacion y  lo mandamos 
                        swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        muestra_lista_usuarios_ajax();
                    },
                    error: function (errorThrown) {
                        alert('Error');
                        console.log(errorThrown);
                    }
                }); // you have missed this bracket
            } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                    ) {
                swalWithBootstrapButtons(
                        'Calcelado',
                        '',
                        ''
                        )
            }
        })
    });
    //funcion que se pasan los datos de un usaurio al formulario  para la edicion  de usuario

    let id_usuario = 0;
    $('#show_data').on('click', '.item_edit', function () {
        id_usuario = $(this).data('edit_id_user');
        seleccionar_el_valor_lista_de_roles($(this).data('edit_rol'), $('#tipo_acceso_edit'));
        $('input[name=nombre_usuario_edit]').val($(this).data('edit_nombre'));
        $('input[name=usuario_usuario_edit]').val($(this).data('edit_usuario'));
    });

    $("#formulario_usuario_edit").submit(function (event) {
        if ($('input[name=nombre_usuario_edit]').val() !== "" &&
                $('input[name=usuario_usuario_edit]').val() !== "" &&
                $('input[name=rol_usuario_edit]').val() !== "") {
            $.ajax({

                type: "POST",
                url: "usuarios/update_usuario",
                data: {idreg_usuarios: id_usuario,
                    usuario_usuario_edit: $("input[name=usuario_usuario_edit]").val()
                    , nombre_usuario_edit: $("input[name=nombre_usuario_edit]").val(),
                    tipo_acceso_edit: $("#tipo_acceso_edit").val()},
                success:
                        function (data) {
                            if (data) {
                                swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                muestra_lista_usuarios_ajax(); //mostramos la lista automaticamente para ver los cambios 
                            } else {
                                swal('El nombre de usuario ya existe', "intenta con otro nombre", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 

                            }
                        },
                error: function (errorThrown) {
                    alert('Error');
                    console.log(errorThrown);
                }
            }); // you have missed this bracket

        } else {
            swal("Todos los campos deben de estar compleatados correctamente", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        event.preventDefault();
    });
    //funcion que  permite la edicion de la contrasenia
    let id_usuario_passwd = 0;
    $('#show_data').on('click', '.item_edit_passwd', function () {
        id_usuario_passwd = $(this).attr('name');
//        alert(id_usuario_passwd);
                                $("#formulario_usuario_edit_passwd")[0].reset();

    });

//submit password modificada
    $("#formulario_usuario_edit_passwd").submit(function (event) {
        if ($('input[name=passwd_usuario_edit]').val() !== "" &&
                $('input[name=passwd_usuario_edit_confirm]').val() !== "" &&
                coincidePassword($("input[name=passwd_usuario_edit]"), $("input[name=passwd_usuario_edit_confirm]"), $('#id_pass_confirma_insert_cambiar'))) {
            $.ajax({
                type: "POST",
                url: "usuarios/update_usuario_passwd",
                data: {idreg_usuario: id_usuario_passwd,
                    passwd_usuario_edit: $("input[name=passwd_usuario_edit]").val()
                },
                success: function (data) {
                            if (data) {
                                swal(data, "click en el boton para continuar[Anota tu contrase&ntilde;a en un lugar seguro]", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
//                                muestra_lista_usuarios_ajax(); //mostramos la lista automaticamente para ver los cambios 
                                $("#formulario_usuario_edit_passwd")[0].reset();
                            } else {
                                swal('no se pudo cambiar la contrase&ntilde;a', "deben de ser 8 caracteres", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                                $("#formulario_usuario_edit_passwd")[0].reset();
                            }
                        },
                error: function (errorThrown) {
                    alert('Error');
                    console.log(errorThrown);
                }
            }); // you have missed this bracket

        } else {
            swal("las contrase&ntilde;as deben de coincidir [8 caracteres]", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        event.preventDefault();
    });


    function seleccionar_el_valor_lista_de_roles(value, $select) {
        $.ajax({
            type: "ajax",
            url: "usuarios/obtener_lista_roles",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        var html = '<option  disabled>Seleccione un rol </option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            if (data[i].id === '' + value + '') {
                                html += '<option selected value="' + data[i].id + '">' +
                                        data[i].rol +
                                        '</option>';
                            } else {
                                html += '<option value="' + data[i].id + '">' +
                                        data[i].rol +
                                        '</option>';
                            }
                        }
                        $select.html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
        });
    }
//funcion que limpia los campos del formulario para ingresar datos del usuario
    $('#limpiar_form_ingre_dat_usuario').on("click", function () {
        $("input[name=nombre_usuario").val("");
        $("input[name=passwd_usuario]").val("");
        $("input[name=rol_usuario]").val("");
    });
//funcion que limpia los campos del formulario de edicion para ingresar datos del usuario
    $('#limpiar_form_edit_ingre_dat_prof').on("click", function () {
        $("input[name=nombre_usuario_edit").val("");
        $("input[name=passwd_usuario_edit]").val("");
        $("input[name=rol_usuario_edit]").val("");
    });
//funcion que muestra la lista  de roles (tipos de usuario)
    $.ajax({
        type: "GET",
        url: "usuarios/obtener_lista_roles",
        async: true,
        dataType: 'json',
        success:
                function (data) {
                    var i;
                    var html = '<option selected disabled>Seleccione una rol</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' +
                                data[i].rol +
                                '</option>';
                    }
                    $('#usuario_tipo_rol').html(html);
                },
        error: function (errorThrown) {
            alert('Error');
            console.log(errorThrown);
        }
    });
//funcion que se ejecuta al agregar aun usuario -- se muestra la lista de roles
    seleccionar_el_valor_lista_de_roles(0, $('#tipo_acceso'));



    //funcion que  compara y valida las contrasenias para la creacion y edicion de usuarios
    ///1.agregamos el campos para el mensaje de confirmacion 
    var span = $('<div id="id_pass_confirma_insert" class="container"></div>').insertAfter($("input[name=passwd_usuario_confirm]"));
    //agegara el campo de mensaje de confirmacion para el modal de edicion dela contraseña
    var span_edit_passwd = $('<div id="id_pass_confirma_insert_cambiar" class="container"></div>').insertAfter($("input[name=passwd_usuario_edit_confirm]"));
    //2.validacion 
    //ejecuta la función al soltar la tecla
    $("input[name=passwd_usuario_confirm]").keyup(function () {
        coincidePassword($("input[name=passwd_usuario]"), $("input[name=passwd_usuario_confirm]"), $('#id_pass_confirma_insert'));
    });
    //ejecuta la función al soltar la tecla
    $("input[name=passwd_usuario_edit_confirm]").keyup(function () {
        coincidePassword($("input[name=passwd_usuario_edit]"), $("input[name=passwd_usuario_edit_confirm]"), $('#id_pass_confirma_insert_cambiar'));
    });
}); //fin de jquery

