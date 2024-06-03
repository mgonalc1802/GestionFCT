$(function(){
    //Mostrar la parte 2 y ocultar la parte 1
    document.getElementById('mostrarParte2').addEventListener('click', function() {
        document.getElementById('parte1').style.display = 'none';
        document.getElementById('parte2').style.display = 'block';
    });

    //Volver a la parte 1 desde la parte 2
    document.getElementById('volverParte1').addEventListener('click', function() {
        document.getElementById('parte2').style.display = 'none';
        document.getElementById('parte1').style.display = 'block';
    });

    //Cuando el select de empresas cambie
    $('#empresas').change(function() {
        //Llama a la función para insertar centros
        traeCentrosEmpresa($(this).val());
    });

    //Generar la acción del boton Generar
    document.getElementById('generar').addEventListener('click', function(ev){
        //Previene el submit que realiza por defecto
        ev.preventDefault();

        //Genera un array para introducir las actividades seleccionadas
        const actividades = [];

        //Obtiene las actividades seleccionadas
        document.querySelectorAll('input[name="actividades[]"]:checked').forEach((checkbox) => 
        {
            actividades.push(checkbox.value);
        });

        //Genera un array para introducir los criterios seleccionados
        const criterios = [];

        //Obtiene los criterios seleccionados
        document.querySelectorAll('input[name="criterios[]"]:checked').forEach((checkbox) => {
            criterios.push(checkbox.value);
        });

        
    });
});

//Función que trae los centros de una determinada empresa
function traeCentrosEmpresa(id){
    //Llamada AJAX que se encarga de traer los centros de una determinada empresa
    $.ajax(
        {
            url: "/API/centrosEmpresa/" + id,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                //Obtiene el contenido html necesario
                var selectCentros = $("#centrosTrabajo");

                //Activa el select
                selectCentros.prop("disabled", false);

                //Vacía el select
                selectCentros.empty();
    
                //Recorre el array que obtiene a través de la API
                for(let i = 0; i < response.length; i++)
                {
                    //Crea un nuevo elemento del select
                    var option = $('<option value = "' + response[i].id + '">' + response[i].localidad +'</option>');
    
                    //Añade al select la opción
                    selectCentros.append(option);
                }       
            }
        });
};