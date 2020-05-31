$(document).ready(function () {
    var id_user = 0;
    $("#formulario_usuario").submit(function (e) {
        $datos = $("#formulario_usuario").serialize();
        if ($datos !== '') {
            $.ajax({
                type: "POST",
                url: "get_existe_usuario",
                data: $datos,
                dataType: 'json',
                async: true,
                success:
                        function (data) {
                            if (data !== null) {
                                id_user = data.idusuario;
                                swal('LLena el siguiente formulario para actualizar tu contrase\u00F1a', "click en el boton para continuar", "success");
                                $("#edit_password").show();
                                $("#password_view_confirmar").hide();
                            } else {
                                swal('El usuario no existe', "click en el boton para continuar", "error");
                            }
                        },
                error: function (errorThrown) {
                    swal('No se puede completar el registro', "click en el boton para continuar", "error");
                    console.log(errorThrown);
                }
            }); // you have missed this bracket
        } else {
            swal('Todos los campos deben de estar completos ', "click en el boton para continuar", "warning");
        }
        return false;
    });
    $("#form_edit_password").submit(function (e) {
        if (coincidePassword($("input[name=passwd_usuario]"),
                $("input[name=passwd_usuario_edit]"),
                $('#id_pass_confirma_insert'))) {
            $.ajax({
                type: "POST",
                url: "update_usuario_passwd",
                data: {idreg_usuario: id_user,
                    passwd_usuario: $("input[name=passwd_usuario]").val(),
                    passwd_usuario_edit: $("input[name=passwd_usuario_edit]").val()
                },
                dataType: 'json',
                async: true,
                success:
                        function (data) {
                            if (data) {
                                swal('contrase\u00F1a actualizada correctamente',
                                        "click en el boton para continuar", "success");
                                $("#edit_password").hide();
                                $("#password_view_confirmar").show();

                            } else {

                            }
                        },
                error: function (errorThrown) {
//                        alert('Error');
                    swal('No se puede completar el registro', "click en el boton para continuar", "error");
                    console.log(errorThrown);
                }
            }); // you have missed this bracket
        } else {
            swal('Las contrase\u00F1as deben coincidir', "click en el boton para continuar", "warning");
        }
        return false;
    });
    $("input[name=passwd_usuario]").password({
        eyeClass: 'fa',
        eyeOpenClass: 'fa-eye',
        eyeCloseClass: 'fa-eye-slash'
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
class="container"></div>').insertAfter($("input[name=passwd_usuario_edit]"));
    //agegara el campo de mensaje de confirmacion para el modal de edicion dela contraseÃ±a
    //2.validacion 
    //ejecuta la funciÃ³n al soltar la tecla
    $("input[name=passwd_usuario_edit]").keyup(function () {
        coincidePassword($("input[name=passwd_usuario]"),
                $("input[name=passwd_usuario_edit]"),
                $('#id_pass_confirma_insert'));
    });

});
