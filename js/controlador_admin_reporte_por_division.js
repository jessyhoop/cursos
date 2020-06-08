var base_url = '/cursos/index.php/';
var get_pdf = function (name_reporte, variables) {
    window.open('generar_pdf_division' + name_reporte + variables, 'reporte', 'directories=no', 'location=no', 'menubar=no', 'scrollbars=yes', 'statusbar=no', 'tittlebar=no', 'width=400', 'height=400');
};
$(document).ready(function () {
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
            $mensaje.text(confirmacion)
                    .removeClass("negacion").addClass('confirmacion');
            return true;
        } else {
            $mensaje.text(negacion)
                    .removeClass("confirmacion").addClass('negacion');
            return false;
        }
    };
    var span = $('<div id="fechas_confirma_insert" class="container"></div>').insertAfter($("input[name=fecha_inicio_curso]"));
    $("input[name=fecha_fin_curso],input[name=fecha_inicio_curso]").change(function () {
        check_fecha_inicio_menor_que_fecha_termino
                ($('input[name=fecha_inicio_curso]').val(), $('input[name=fecha_fin_curso]').val(), $('#fechas_confirma_insert'));
//    alert('fd');
    });

    $('#boton_generar_reporte').hide();
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

    $("#mostrar_datos").on('click', function () {
        if ($('#fecha_inicio_curso').val() && $('#fecha_fin_curso').val() && check_fecha_inicio_menor_que_fecha_termino
                ($('input[name=fecha_inicio_curso]').val(), $('input[name=fecha_fin_curso]').val(), $('#fechas_confirma_insert'))) {

            $.ajax({
                type: "GET",
                url: 'reporte_por_division',
                data: {fecha_inicio: $('#fecha_inicio_curso').val(), fecha_fin: $('#fecha_fin_curso').val()},
                success:
                        function (data) {
                            if (data) {
//                                alert(data);
                                $('#tabla').html(data);
                                $('#boton_generar_reporte').show();
                                $('#boton_generar_reporte').on('click', function () {
                                    var values = create_values_for_send_pdf({
                                        fecha_inicio: $('#fecha_inicio_curso').val(), fecha_fin: $('#fecha_fin_curso').val()});
                                    get_pdf('', values);
                                });
                            } else {
                                alert('no hay datos');
                            }
                        },
                error: function (errorThrown) {
//                    alert('ningun dato');
                    swal("No se encontraron datos", "no se encontraron datos", "warning");//mandamos el mensaje de la validacion y  lo mandamos 
                    $('#datos_evaluaciones').html('');
                    $('#boton_generar_reporte').hide();

//                    console.log(errorThrown);
                }
            });

//            alert($('#fecha_inicio_curso').val() + 'mes:' + $('#fecha_fin_curso').val());

        } else {
            swal("Ingresa una fecha correcta", "", "warning");//mandamos el mensaje de la validacion y  lo mandamos 

        }
    });
//
//$('#boton_generar_reporte').on('click', function () {
//
//                                var values = create_values_for_send_pdf({id_curso: 1});
//                                get_pdf('', values);
//
//                            });
});