$(function(){
    
    //Obtiene el botón de Guardar Archivo
    document.getElementById("guardar").addEventListener('click', function(ev) {
        //Previene el evento submit que tiene por defecto
        ev.preventDefault();

        //Llama al método para subir archivos
        subirEncuesta();
    });
});

function subirEncuesta(){
    var formData = new FormData();
    var files = $('#subir')[0].files;

    if (files.length > 0) 
    {
        formData.append('file', files[0]);

        $.ajax(
        {
            url: '/API/subirEncuesta',
            type: 'post',
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(response) 
            {
                console.log(response);
                alert("Archivo subido correctamente.");
                window.location.href = "/datos";
            }
        });
    } 
    else 
    {
        console.log("No se ha seleccionado ningún archivo.");
    }
}