$(document).ready(function () {
    $("input[name=passwd_usuario_edit]").password({
        eyeClass: 'fa',
        eyeOpenClass: 'fa-eye',
        eyeCloseClass: 'fa-eye-slash'
    });
    $("input[name=passwd_usuario]").password({
        eyeClass: 'fa',
        eyeOpenClass: 'fa-eye',
        eyeCloseClass: 'fa-eye-slash'
    });
////======================================= U S U A R I O S ===============================
    $("#formulario_usuario").submit(function (e) {
        if (
                $('input[name=nombre_usuario]').val() !== "" &&
                $('input[name=apellidop_usuario]').val() !== "" &&
                $('input[name=apellidom_usuario]').val() !== "" &&
                $('input[name=rfc_usuario]').val() !== "" &&
                $('input[name=correo_usuario]').val().match("^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$") && $('input[name=rfc_usuario]').val() !== "" &&
                $('input[name=numcuenta_usuario]').val() !== "" &&
                coincidePassword($("input[name=passwd_usuario]"),
                        $("input[name=passwd_usuario_confirm]"),
                        $('#id_pass_confirma'))
                )
        {
            $datos_usuario = $("#formulario_usuario").serialize();
            $.ajax({
                type: "POST",
                url: "insert_usuario_profesor",
                data: $datos_usuario,
                dataType: 'json',
                async: true,
                success:
                        function (data) {
                            var mensaje = JSON.stringify(data.mensaje);
                            if (data.codigo === 404) {
                                swal(mensaje, "click en el boton para continuar", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                            } else {
                                swal(mensaje, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                $("#formulario_usuario")[0].reset();//limpia valores del formulario
                                lista_profesores();
                            }
                        },
                error: function (errorThrown) {
                    swal("Error al registrarte", "click en el boton para continuar", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                }
            }); // you have missed this bracket
        } else {
            swal("Todos los campos deben de estar llenos correctmente", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        return false;
    });
//   funcion que muestra la lista de usuarios al hacer click 
    $('#muestra_lista_profesores').on("click", function () {
//funcion que muestra la lista de profesores
        lista_profesores();
    });

    function lista_profesores() {
        $.ajax({
            type: "get",
            url: "lista_profesores",
            async: true,
            dataType: 'json',
            success:
                    function (data) {

                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                    '<td class="actions-ancors">' + data[i].nombre_com + '</td>' +
                                    '<td class="actions-ancors">' + data[i].rfc + '</td>' +
                                    '<td class="actions-ancors">' + data[i].num_cuenta + '</td>' +
                                    '<td class="actions-ancors">' + data[i].correoelectronico + '</td>' +
                                    '<td class="actions-ancors" style="text-align:center;">' +
                                    '<a data-toggle="modal" data-target="#editUser" href="javascript:void(0);" \n\
                                class="item_edit" data-edit_id_user="'
                                    + data[i].usuario_idusuario
                                    + '"data-edit_nombre="' + data[i].nombre
                                    + '"data-edit_apellido_pat="' + data[i].apellido_p
                                    + '"data-edit_apellido_mat="' + data[i].apellido_m
                                    + '"data-edit_rfc="' + data[i].rfc
                                    + '"data-edit_correo_elec="' + data[i].correoelectronico
                                    + '"data-edit_num_edit_num_cuenta="' + data[i].num_cuenta + '">\n\
                               <i class="fa fa-user-edit"></i><span class="editar ml-2"></span></a>' + '  ' +
                                    '&nbsp; &nbsp;<a href="javascript:void(0);" class="item_delete" name="' + data[i].usuario_idusuario + '"><i class="fa fa-user-times"></i><span class="borrar ml-2"></span></a>&nbsp;&nbsp;' +
                                    '<a data-toggle="modal" class="item_edit_passwd" data-target="#editUserPasswd" href="javascript:void(0);" name="' + data[i].usuario_idusuario + '"><i class="fas fa-key"></i><span class="edicion ml-2"></span></a>' +
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
            title: '�Estas seguro de eliminar este registro?',
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
                    url: "eliminar_usuario",
                    data: {idreg_usuario: idreg_usuario},
                    success: function (data) {
                        swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        lista_profesores();
                    },
                    error: function (errorThrown) {
                        swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        console.log(errorThrown);
                    }
                }); // you have missed this bracket
            } else if (
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
        $('input[name=nombre_usuario_edit]').val($(this).data('edit_nombre'));
        $('input[name=apellidop_usuario_edit]').val($(this).data('edit_apellido_pat'));
        $('input[name=apellidom_usuario_edit]').val($(this).data('edit_apellido_mat'));
        $('input[name=rfc_usuario_edit]').val($(this).data('edit_rfc'));
        $('input[name=correo_usuario_edit]').val($(this).data('edit_correo_elec'));
        $('input[name=numcuenta_usuario_edit]').val($(this).data('edit_num_edit_num_cuenta'));
    });

    $("#formulario_usuario_edit").submit(function (event) {
        if (
                $('input[name=nombre_usuario_edit]').val() !== "" &&
                $('input[name=apellidop_usuario_edit]').val() !== "" &&
                $('input[name=apellidom_usuario_edit]').val() !== "" &&
                $('input[name=rfc_usuario_edit]').val() !== "" &&
                $('input[name=correo_usuario_edit]').val().match("^[_a-z0-9-]+(.[_a-z0-9-]+)*@(aragon.unam.mx)$") &&
                $('input[name=numcuenta_usuario_edit]').val() !== ""
                )
        {
            $.ajax({

                type: "POST",
                url: "update_usuario_profesor",
                data: {id_usuario: id_usuario,
                    nombre_usuario_edit: $("input[name=nombre_usuario_edit]").val(),
                    apellidop_usuario_edit: $("input[name=apellidop_usuario_edit]").val(),
                    apellidom_usuario_edit: $("input[name=apellidom_usuario_edit]").val(),
                    rfc_usuario_edit: $("input[name=rfc_usuario_edit]").val(),
                    correo_usuario_edit: $("input[name=correo_usuario_edit]").val(),
                    numcuenta_usuario_edit: $("input[name=numcuenta_usuario_edit]").val(),
                },
                dataType: 'json',
                async: true,
                success:
                        function (data) {
                            var mensaje = JSON.stringify(data.mensaje);
                            if (data.codigo === 404 || data.codigo === 401) {
                                swal(mensaje, "click en el boton para continuar", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                            } else {
                                swal('Registro actualizado con exito', "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                $("#formulario_usuario")[0].reset();//limpia valores del formulario
                                lista_profesores();
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
        $("#formulario_usuario_edit_passwd")[0].reset();

    });

//submit password modificada
    $("#formulario_usuario_edit_passwd").submit(function (event) {
        if ($('input[name=passwd_usuario_edit]').val() !== "" &&
                $('input[name=passwd_usuario_edit_confirm]').val() !== "" &&
                coincidePassword($("input[name=passwd_usuario_edit]"), $("input[name=passwd_usuario_edit_confirm]"), $('#id_pass_confirma_insert_cambiar'))) {
            $.ajax({
                type: "POST",
                url: "update_usuario_passwd",
                data: {idreg_usuario: id_usuario_passwd,
                    passwd_usuario_edit: $("input[name=passwd_usuario_edit]").val()
                },
                success: function (data) {
                    if (data) {
                        swal('Contrase\u00F1a Actualizada correctamente', "\
[Anota tu contrase\u00F1a en un lugar seguro]", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        $("#formulario_usuario_edit_passwd")[0].reset();
                    } else {
                        swal('no se pudo cambiar la contrase\u00F1a', "deben de ser 8 caracteres", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
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

    function coincidePassword($pass1, $pass2, $mensaje) {
        var confirmacion = "Las contrase\u00F1as si coinciden";
        var negacion = "No coinciden las contrase\u00F1as";
        //muestro el span
        $mensaje.show().removeClass();
        if ($pass1.val().length !== 0 && $pass1.val() === $pass2.val()) {
            $mensaje.text(confirmacion).removeClass("negacion").addClass('confirmacion');
            return true;
        } else
        {
            $mensaje.text(negacion).removeClass("confirmacion").addClass('negacion');
            return false;
        }
    }

    //funcion que  compara y valida las contrasenias para la creacion y edicion de usuarios
    ///1.agregamos el campos para el mensaje de confirmacion 
    var span = $('<div id="id_pass_confirma_insert" \n\
class="container"></div>').insertAfter($("input[name=passwd_usuario_confirm]"));
    //agegara el campo de mensaje de confirmacion para el modal de edicion dela contraseÃ±a
    //2.validacion 
    $("input[name=passwd_usuario_confirm]").keyup(function () {
        coincidePassword($("input[name=passwd_usuario]"),
                $("input[name=passwd_usuario_confirm]"),
                $('#id_pass_confirma_insert'));
    });
});