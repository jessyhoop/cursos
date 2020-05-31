/* global id_user */

$(document).ready(function () {

//==============================F U N C I O N E S      G E N E R A L E S-------------------------
//=====================================================================================
//    $('#list_cursos').DataTable({});
//funcion que valida que la fecha de incio sea menor a la fecha de termino
    var check_fecha_inicio_menor_que_fecha_termino = function (fecha_inicio, fecha_termino, $mensaje) {
        var confirmacion = "El intervalo de tiempo en la fecha es correcto";
        var negacion = "No coinciden las fecha";
        //muestro el span
        $mensaje.show().removeClass();
//          02-12-2029
//        2020-04-22
//        new Date(year, month, day, hours, minutes, seconds, milliseconds)
//        alert(fecha_inicio + '-' + fecha_termino);
        var fecha_inicio_split = fecha_inicio.split('-');
        var fecha_termino_split = fecha_termino.split('-');
        var fecha_inicio = new Date(fecha_inicio_split[0], fecha_inicio_split[1], fecha_inicio_split[2]).getTime();
        var fecha_termino = new Date(fecha_termino_split[0], fecha_termino_split[1], fecha_termino_split[2]).getTime();
        if (fecha_termino >= fecha_inicio) {
            $mensaje.text(confirmacion).removeClass("negacion").addClass('confirmacion');
            return true;
        } else {
            $mensaje.text(confirmacion).removeClass("confirmacion").addClass('negacion');
            return false;
        }
    };


//=================================M O D U L O   D E   C U R S O S --------------------------------------------- 
//==========================================================================================================
    var span = $('<div id="fechas_confirma_insert" class="container"></div>').insertAfter($("input[name=fecha_fin_curso]"));
    $("input[name=fecha_fin_curso],input[name=fecha_inicio_curso]").change(function () {
        check_fecha_inicio_menor_que_fecha_termino
                ($('input[name=fecha_inicio_curso]').val(), $('input[name=fecha_fin_curso]').val(), $('#fechas_confirma_insert'));
//    alert('fd');
    });
    //funciones para la edicion de  evaluacines
    span = $('<div id="fechas_confirma_insert_edit" class="container"></div>').insertAfter($("input[name=fecha_fin_curso_edit]"));
    $("input[name=fecha_fin_curso_edit],input[name=fecha_inicio_curso_edit]").change(function () {
        check_fecha_inicio_menor_que_fecha_termino($('input[name=fecha_inicio_curso_edit]').val(), $('input[name=fecha_fin_curso_edit]').val(), $('#fechas_confirma_insert_edit'));
//    alert('fd');
    });

    //funcion qeue selecciona la opcion correspondiente de la base de datos
    function    seleccionar_el_valor_lista_de_carreras(value) {
        $.ajax({
            type: "ajax",
            url: "lista_carreras",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        var html = '<option  selected disabled>Seleccione una carrera</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            if (data[i].idcarrera === '' + value + '') {
                                html += '<option  selected value="' + data[i].idcarrera + '">' +
                                        data[i].carrera +
                                        '</option>';
                            } else {
                                html += '<option   value="' + data[i].idcarrera + '">' +
                                        data[i].carrera +
                                        '</option>';
                            }
                        }
//                    $('#carrera_id_curso').append(html);
                        $('#carrera_id_curso_edit').html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }

        });
    }
//funcion que muestra la lista de profesores

//funcion que muestra la lista de carreras
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
                    $('#carrera_id_curso').html(html);
//                    $('#carrera_id_curso_edit').append(html);
                },
        error: function (errorThrown) {
            alert('Error');
            console.log(errorThrown);
        }

    });
    
//funcion que almacena los datos de la nueva curso
    $("#formulario_curso").submit(function (e) {
        if ($('input[name=turno_curso]').val() !== "" &&
                $('input[name=curso_curso]').val() !== "" &&
                $('input[name=fecha_inicio_curso]').val() !== "" &&
                $('input[name=fecha_fin_curso]').val() !== "" &&
                $('input[name=cupo_curso]').val() !== "" &&
                $('input[name=carrera_id_curso]').val() !== "" &&
                $('input[name=hora_inicio_curso]').val() !== "" &&
                $('input[name=hora_fin_curso]').val() !== "") {

            if (!check_fecha_inicio_menor_que_fecha_termino($('input[name=fecha_inicio_curso]').val(), $('input[name=fecha_fin_curso]').val(), $('#fechas_confirma_insert'))) {
                //    swal("La fecha de inicio debe ser menor que la de termino ", "", "error");//mandamos el mensaje de la validacion y  lo mandamos 
            } else {
                $datos_curso = $("#formulario_curso").serialize();
                $.ajax({
                    type: "POST",
                    url: "insert_curso",
                    data: $datos_curso,
                    success:
                            function (data) {
                                if (data) {
                                    swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                                    $("#formulario_curso")[0].reset();//limpia valores del formulario
                                    muestra_lista_cursos_ajax();

                                } else {
                                    swal('Esta curso ya existe', "click en el boton para continuar", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
                                }
                            },
                    error: function (errorThrown) {
                        alert('Error');
                        console.log(errorThrown);
                    }
//
                }); // you have missed this bracket

            }
        } else {
            swal("Todos los campos deben de estar llenos", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
        }
        return false;
    });
    //   funcion que muestra la lista de cursos al hacer click al boton
    $('#muestra_lista_de_cursos').on("click", function () {
        //funcion que muestra la lista de profesores
        muestra_lista_cursos_ajax();
    });
    //funcion que trae los datos de la base de datos  de cursos con ajax
    function muestra_lista_cursos_ajax() {
        $.ajax({
            type: "ajax",
            url: "lista_cursos",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        if (data) {
                            var html = '';
                            var i;
                            for (i = 0; i < data.length; i++) {
                                html += '<tr>' +
                                        '<td>' + data[i].turno + '</td>' +
                                        '<td>' + data[i].curso + '</td>' +
                                        '<td>' + data[i].carrera + '</td>' +
                                        '<td>' + data[i].nombre + '</td>' +
                                        '<td>' + data[i].fecha_inicio + '</td>' +
                                        '<td>' + data[i].fecha_fin + '</td>' +
                                        '<td>' + data[i].hora_inicio + '</td>' +
                                        '<td>' + data[i].hora_fin + '</td>' +
                                        '<td>' + data[i].cupo + '</td>' +
                                        '<td style="text-align:right;">' +
                                        '<a data-toggle="modal" \n\
data-target="#editEval" href="javascript:void(0);" \n\
class="item_edit_curso" data-edit_id_curso="'
                                        + data[i].idcurso
                                        + '"data-edit_turno="'
                                        + data[i].turno
                                        + '"data-edit_curso="' + data[i].curso
                                        + '"data-edit_cupo="' + data[i].cupo
                                        + '"data-edit_id_carrera="' + data[i].carrera_idcarrera
                                        + '"data-edit_fecha_inicio="' + data[i].fecha_inicio
                                        + '"data-edit_fecha_fin="' + data[i].fecha_fin
                                        + '"data-edit_hora_inicio="' + data[i].hora_inicio
                                        + '"data-edit_hora_fin="' + data[i].hora_fin
                                        + '">\n\
<i class="fa fa-edit"></i><span class="editar ml-2">Editar</span></a>' + '</td><td>   ' +
                                        '<a href="javascript:void(0);" class="item_delete_curso" name="' + data[i].idcurso + '"><i class="fa fa-trash-alt"></i><span class="borrar ml-2">Borrar</span></a>' +
                                        '</td>' +
                                        '</tr>';

                            }
                            $('#show_datos_cursos').html(html);
                        } else {
                            $('#show_datos_cursos').html('');

                        }

                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
        }); // you have missed this bracket
    }

//funcion que elimina un registro curso de la  base de datos con mensaje de confirmacion 
    $('#show_datos_cursos').on('click', '.item_delete_curso', function () {
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
                var id_curso = $(this).attr('name');
                $.ajax({

                    type: "POST",
                    url: "eliminar_curso",
                    data: {idcurso: id_curso},
                    success: function (data) {
//                        swal(data,"Profdesor eliminado", "succes");//mandamos el mensaje de la validacion y  lo mandamos 
                        swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                        muestra_lista_cursos_ajax();
                    },
                    error: function (errorThrown) {
                        alert('Error');
                        console.log(errorThrown);
                    }
                }); // you have missed this bracket
            } else if (// si se cancela la opcion para a la ventana de canceladp
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

    //funcion que se pasan los datos para la edicion  de la cursos
    var id_curso = 0;
    $('#show_datos_cursos').on('click', '.item_edit_curso', function () {
        id_curso = $(this).data('edit_id_curso');
        $("#turno_curso_edit option[value=" + $(this).data('edit_turno') + "]").attr("selected", true);//buscamos en el select y le agregamos la propiedad de selected para que aparesca
        seleccionar_el_valor_lista_de_carreras($(this).data('edit_id_carrera'));
        $('input[name=fecha_inicio_curso_edit]').val($(this).data('edit_fecha_inicio'));
        $('input[name=fecha_fin_curso_edit]').val($(this).data('edit_fecha_fin'));
        $('input[name=hora_inicio_curso_edit]').val($(this).data('edit_hora_inicio'));
        $('input[name=hora_fin_curso_edit]').val($(this).data('edit_hora_fin'));
        $('input[name=cupo_curso_edit]').val($(this).data('edit_cupo'));
        $('input[name=curso_curso_edit]').val($(this).data('edit_curso'));
    });
    $("#formulario_curso_edit").submit(function (event) {
        if ($('input[name=turno_curso_edit]').val() !== "" &&
                $('input[name=carrera_id_curso_edit]').val() !== "" &&
                $('input[name=cupo_curso_edit]').val() !== "" &&
                $('input[name=curso_curso_edit]').val() !== "" &&
                $('input[name=fecha_inicio_curso_edit]').val() !== "" &&
                $('input[name=fecha_fin_curso_edit]').val() !== "" &&
                $('input[name=hora_inicio_curso_edit]').val() !== "" &&
                $('input[name=hora_fin_curso_edit]').val() !== "" &&
                check_fecha_inicio_menor_que_fecha_termino($('input[name=fecha_inicio_curso_edit]').val(), $('input[name=fecha_fin_curso_edit]').val(), $('#fechas_confirma_insert_edit')))
        {
            $.ajax({
                type: "POST",
                url: "update_curso",
                data: {
                    id_curso: id_curso,
                    turno_curso_edit: $("#turno_curso_edit").val(),
                    carrera_id_curso_edit: $("#carrera_id_curso_edit").val(),
                    cupo_curso_edit: $("input[name=cupo_curso_edit]").val(),
                    curso_curso_edit: $("input[name=curso_curso_edit]").val(),
                    fecha_inicio_curso_edit: $("input[name=fecha_inicio_curso_edit]").val(),
                    fecha_fin_curso_edit: $("input[name=fecha_fin_curso_edit]").val(),
                    hora_inicio_curso_edit: $("input[name=hora_inicio_curso_edit]").val(),
                    hora_fin_curso_edit: $("input[name=hora_fin_curso_edit]").val()},
                success:
                        function (data) {
                            swal(data, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                            muestra_lista_cursos_ajax(); //mostramos la lista automaticamente para ver los cambios 
//                                        limpia_valores_form_edit_curso();
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

}); //fin de jquery

