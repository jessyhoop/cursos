$(document).ready(function () {
    load_data();
    function load_data()
    {
        $.ajax({
            url: "load_data_alumno",
            method: "POST",
            success: function (data)
            {
                $('#imported_csv_data').html(data);
            }
        })
    }

    $('#import_csv').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "import_alumno",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#import_csv_btn').html('Importing...');
            },
            success: function (data)
            {
                $('#import_csv')[0].reset();
                $('#import_csv_btn').attr('disabled', false);
                $('#import_csv_btn').html('Import Done');
                load_data();
            }
        })
    });
});