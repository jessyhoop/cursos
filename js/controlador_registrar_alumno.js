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

    $('.carreraOpt').hide();

    $("#formulario_usuario").submit(function (e) {
        alert($('#carrera1').val());
        alert($('#carrera2').val());
        if (
                $('input[name=nombre_usuario]').val() !== "" &&
                $('input[name=apellidop_usuario]').val() !== "" &&
                $('input[name=apellidom_usuario]').val() !== "" &&
                $('input[name=rfc_usuario]').val() !== "" &&
                $('input[name=correo_usuario]').val() !== "" &&
                $('input[name=rfc_usuario]').val() !== "" &&
                $('input[name=numcuenta_usuario]').val() !== "" &&
                coincidePassword($("input[name=passwd_usuario]"),
                        $("input[name=passwd_usuario_confirm]"),
                        $('#id_pass_confirma')) &&
                ($('#carrera1').val() !== $('#carrera2').val())
                )
        {
            $datos_usuario = $("#formulario_usuario").serialize();
            $.ajax({
                type: "POST",
                url: "insert_usuario_alumno",
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
    $('.otraCarrera').on('change', function () {
        if ($(this).is(':checked')) {
            $('.carreraOpt').show();
        } else {
            $('.carreraOpt').hide();
            $('#carrera2').val('');
        }
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
    //ejecuta la funciÃ³n al soltar la tecla
    $("input[name=passwd_usuario_confirm]").keyup(function () {
        coincidePassword($("input[name=passwd_usuario]"),
                $("input[name=passwd_usuario_confirm]"),
                $('#id_pass_confirma_insert'));
    });

    $.ajax({
        type: "GET",
        url: "lista_carreras",
        async: true,
        dataType: 'json',
        success:
                function (data) {
                    var html = '<option  selected disabled>Seleccione una carrera</option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].idcarrera + '">' +
                                data[i].carrera +
                                '</option>';
                    }
                    $('.carreras').html(html);
                },
        error: function (errorThrown) {
            alert('Error');
            console.log(errorThrown);
        }

    });
});