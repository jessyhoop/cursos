$(document).ready(function () {
    get_cursos_by_alumno();
    function get_datos_curso($id_curso) {

        $.ajax({
            type: "GET",
            url: "alumnos/lista_curso_by_id",
            async: true,
            data: {idcurso: $id_curso},
            dataType: 'json',
            success:
                    function (data) {
                        var html = '';
                        html += '<tr>' +
                                '<td>' + data.turno + '</td>' +
                                '<td>' + data.curso + '</td>' +
                                '<td>' + data.carrera + '</td>' +
                                '<td>' + data.nombre + '</td>' +
                                '<td>' + data.fecha_inicio + '</td>' +
                                '<td>' + data.fecha_fin + '</td>' +
                                '<td>' + data.hora_inicio + '</td>' +
                                '<td>' + data.hora_fin + '</td>' +
                                '<td>' + data.cupo + '</td>' +
                                '<td class="text-danger">' + (data.cupo - data.registrados.cantidad) + '</td>' +
                                '</tr>';
                        $('#show_datos_curso').html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
        }); // yo
    }
    $.ajax({
        type: "GET",
        url: "alumnos/lista_cursos",
        async: true,
        dataType: 'json',
        success:
                function (data) {
                    var html = '<option  selected disabled>Seleccione un curso para inscribirse </option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].idcurso + '">' +
                                data[i].curso +' -Periodo:'+data[i].fecha_inicio+' al '+data[i].fecha_fin+
                                ' -Horario:'+data[i].hora_inicio+' a '+data[i].hora_fin+
                                '</option>';
                    }
                    $('#lista_de_cursos').html(html);
//                    $('#carrera_id_curso_edit').append(html);
                },
        error: function (errorThrown) {
            alert('Error');
            console.log(errorThrown);
        }
    });
    $('#lista_de_cursos').change(function () {
        get_datos_curso($(this).val());

    });
    function get_cursos_by_alumno() {

        $.ajax({
            type: "GET",
            url: "alumnos/get_cursos_by_alumno",
            async: true,
            dataType: 'json',
            success:
                    function (data) {
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
                                    '<td>   ' +
                                    '<a href="javascript:void(0);" class="item_delete_curso" name="' + data[i].id_alumno_curso + '"><i class="fa fa-trash-alt"></i><span class="borrar ml-2">Borrar</span></a>' +
                                    '</td>' +
                                    '</tr>';

                        }
                        $('#show_datos_cursos_inscritos').html(html);
                    },
            error: function (errorThrown) {
                alert('Error');
                console.log(errorThrown);
            }
        }); // yo
//-----------------------------------E LI M I N A R    C U R S O   I N S C R I T O
        $('#show_datos_cursos_inscritos').on('click', '.item_delete_curso', function () {
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
                        type: "get",
                        url: "alumnos/eliminar_curso",
                        data: {idcurso: id_curso},
                        success: function (data) {
                            swal("Registro Eliminado", "", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
                            get_cursos_by_alumno();
                        },
                        error: function (errorThrown) {
                            swal("Registro no eliminado correctamente", "", "error"); //mandamos el mensaje de la validacion y  lo mandamos 
                            console.log(errorThrown);
                        }
                    }); // you have missed this bracket
                } else if (// si se cancela la opcion para a la ventana de canceladp
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


    }


    $("#formulario_inscripcion").submit(function (e) {
        $id_curso = $("#formulario_inscripcion").serialize();
        if ($id_curso !== '') {
            $.ajax({
                type: "POST",
                url: "alumnos/insert_curso_alumno",
                data: $id_curso,
                dataType: 'json',
                async: true,
                success:
                        function (data) {
                            var mensaje = JSON.stringify(data.mensaje);
                            if (data.codigo === 401) {
                                swal(mensaje, "click en el boton para continuar", "warning"); //mandamos el mensaje de la validacion y  lo mandamos 
                            } else {
                                swal(mensaje, "click en el boton para continuar", "success"); //mandamos el mensaje de la validacion y  lo mandamos 
//                                $("#formulario_usuario")[0].reset();//limpia valores del formulario
                                get_cursos_by_alumno();
                            }
                        },
                error: function (errorThrown) {
//                        alert('Error');
                    swal('No se puede completar el registro', "click en el boton para continuar", "error");
                    console.log(errorThrown);
                }
            }); // you have missed this bracket
        } else {
            swal('Selecciona un curso', "click en el boton para continuar", "warning");
        }
        return false;
    });
});
