$(function(){
    
    //Obtiene el botón de Guardar Archivo
    document.getElementById("guardar").addEventListener('click', function(ev) {
        //Previene el evento submit que tiene por defecto
        ev.preventDefault();

        //Llama al método para subir archivos
        subirArchivos();
    });

    //Obtiene el botón de Enviar Email
    document.getElementById("enviarEmail").addEventListener('click', function(ev){
        //Previene el evento submit que tiene por defecto
        ev.preventDefault();

        //Obtiene el pdf a Enviar
        var pdf = $("#pdfFile").val();

        //Obtiene el select de profesores
        var profesorRemitente = $("#profesorRemitente").val();

        //Obtiene el select de profesores
        var empresaDestinataria = $("#empresaDestinataria").val();

        //Genera el json
        var json = 
        {
            "profesorRemitente": profesorRemitente,
            "empresaDestinataria": empresaDestinataria,
            "rutaPDF": pdf
        };

        //Llama a la función para enviar el pdf por correo
        enviarEmail(json);
    });
});

function subirArchivos(){
    var formData = new FormData();
    var files = $('#subir')[0].files;

    if (files.length > 0) 
    {
        formData.append('file', files[0]);

        $.ajax(
        {
            url: '/API/subirArchivos',
            type: 'post',
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(response) 
            {
                console.log(response);
                alert("Archivo subido correctamente.");
                window.location.href = "/datosGenerales";
            }
        });
    } 
    else 
    {
        console.log("No se ha seleccionado ningún archivo.");
    }
}

function enviarEmail(json){
    //Llamada AJAX que se encarga de generar el PDF
    $.ajax(
        {
            url: "/API/enviarEmail",
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(json), 
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                alert(response);
                window.location.href = "/datosGenerales";
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText)
                alert('Error: ' + xhr.responseText);
            }
        });
}