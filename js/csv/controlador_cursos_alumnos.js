$(document).ready(function () {

    load_data();
    function load_data()
    {
        $.ajax({
            url: "load_data_alumno_curso",
            async: true,
            Method: 'GET',
            dataType: 'json',
            success:
                    function (data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + data[i].nombre_completo + '</td>' +
                                    '<td>' + data[i].correoelectronico + '</td>' +
                                    '<td>' + data[i].abreviatura + '</td>' +
                                    '<td>' + data[i].curso + '</td>' +
                                    '<td>' + data[i].fecha_inicio + '-' + data[i].fecha_fin + '</td>' +
                                    '<td>' + data[i].hora_inicio + '-' + data[i].hora_fin + '</td>' +
                                    '<td>' + data[i].nombre_profesor + '</td>' +
                                    '</tr>';
                        }
                        $('#show_data').html(html);
                    },
            error: function (errorThrown) {
                swal("No se encontraron los siguientes datos",
                        "clic para continuar", "error");//mandamos el mensaje de la validacion y  lo mandamos 
                console.log(errorThrown);
            }
        });
    }
    function load_not_data(data)
    {
        var html = '';
        var i;
        for (i = 0; i < data.length; i++) {
            html += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td>' + data[i].nombre + '</td>' +
                    '<td>' + data[i].correo + '</td>' +
                    '<td>' + data[i].carrera + '</td>' +
                    '<td>' + data[i].curso + '</td>' +
                    '<td>' + data[i].fecha + '-' + data[i].fecha + '</td>' +
                    '<td>' + data[i].hora + '-' + data[i].hora + '</td>' +
                    '</tr>';
        }
        $('#show_data').html(html);
    }

    $('#import_csv').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "import_alumno_curso",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            async: true,
            beforeSend: function () {
                $('#import_csv_btn').html('Importando...');
            },
            success: function (data)
            {
                if (data === 0) {
                    swal("Importacion correcta de datos",
                            "clic para continuar", "success");//mandamos el mensaje de la validacion y  lo mandamos 

                    $('#import_csv')[0].reset();
                    $('#import_csv_btn').attr('disabled', false);
                    $('#import_csv_btn').html('Importaci\u00F3n Correcta');
                    load_data();
                } else {
                    swal("No se ingresaron los siguientes registros",
                            "velve a subir los siguientes registros", "warning");//mandamos el mensaje de la validacion y  lo mandamos 
                    $('#import_csv_btn').attr('disabled', false);
                    $('#import_csv_btn').html('Error');
                    load_not_data(data);
                }
            }
        });
    });
}
);