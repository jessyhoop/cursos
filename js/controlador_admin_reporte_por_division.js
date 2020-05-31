base_url = '/cursos/index.php/';
var get_pdf = function (name_reporte, variables) {
//         http://localhost/ccaragon/codeigniter/index.php/reportes/index.php/Reportes/Listado_general_por_orden_alfabetico_por_mes/generar_pdf_listado_general_por_orden_alfabetico_por_mes_aniogenerar_pdf_listado_general_por_orden_alfabetico_por_mes_anio?mes=08&anio=2018
    window.open('generar_pdf_division' + name_reporte + variables, 'reporte', 'directories=no', 'location=no', 'menubar=no', 'scrollbars=yes', 'statusbar=no', 'tittlebar=no', 'width=400', 'height=400');
};
$(document).ready(function () {
    get_cursos_by_profesor();
//    $('#boton_generar_reporte').hide();
    function create_values_for_send_pdf(datos_formulario) {
        var data_get;
        var i = 0;// se usa para que el primer parametro no mande el & al primer valor
        for (var key in datos_formulario) {
                if (i !== 0) {
                data_get = data_get + '&' + key + '=' + datos_formulario[key];
            } else {
                data_get = '?' + key + '=' + datos_formulario[key];
            }
            i++;
        }
        return  data_get; // se construye el texto
    }

    function get_cursos_by_profesor() {
        $.ajax({
            type: "GET",
            url:
                    base_url + 'admin_cursos/lista_cursos',
            async: true,
            dataType: 'json',
            success:
                    function (data) {
                        var html = '<option selected disabled >Seleccione un curso</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].idcurso + '">' +
                                    data[i].curso + ' -Fecha Inicio:' + data[i].fecha_inicio + ' -Fecha Fin:' + data[i].fecha_fin + '-Turno:' + data[i].turno +
                                    '</option>';
                        }
                        $('#cursos').html(html);
                    },
            error: function (errorThrown) {
                swal("No se encontraron datos", "no se encontraron datos", "warning");//mandamos el mensaje de la validacion y  lo mandamos 
            }

        });

    }

    $("#cursos").change(function () {
        var id_curso = $(this).val();
        $.ajax({
            type: "GET",
            url:base_url+ 'admin_cursos/get_alumnos_by_curso',
            data: {id_curso: $(this).val()},
            dataType: 'json',
            success:
                    function (data) {
                        if (data) {
                            var html = '';

                            var i;
                            for (i = 0; i < data.length; i++) {
                                html += '<tr>' +
                                        '<td>' + data[i].nombre_alumno + '</td>' +
                                        '<td>' + data[i].num_cuenta + '</td>' +
                                        '</tr>';
                            }
                            $('#datos_alumnos').html(html);
//                            $('#boton_generar_reporte').show();
                            




                        } else {
                            swal("No hay alumnos inscritos en este curso", "no se encontraron datos", "warning");//mandamos el mensaje de la validacion y  lo mandamos 
                            $('#datos_alumnos').html('');
//                            $('#boton_generar_reporte').hide();
                        }
                    },
            error: function (errorThrown) {
                swal("No se encontraron datos", "no se encontraron datos", "warning");//mandamos el mensaje de la validacion y  lo mandamos 
                $('#datos_alumnos').html('');
//                $('#boton_generar_reporte').hide();
            }
        });

    });

$('#boton_generar_reporte').on('click', function () {

                                var values = create_values_for_send_pdf({id_curso: 1});
                                get_pdf('', values);

                            });
});