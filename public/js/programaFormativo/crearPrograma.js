$(function(){
    //Llama a un método para asignar datePicker personalizados
    personalizaDatePicker();

    //Cuando el select de empresas cambie
    $('#empresas').change(function() {
        //Llama a la función para insertar centros
        traeCentrosEmpresa($(this).val());
    });

    //Generar la acción del boton Generar
    document.getElementById('generar').addEventListener('click', function(ev){
        //Previene el submit que realiza por defecto
        ev.preventDefault();

        //Obtiene el alumno seleccionado
        var alumno = document.getElementById("alumnos").value;

        //Obtiene el tutor laboral seleccionado
        var tutorLaboral = document.getElementById("tutoresLaborales").value;

        //Obtiene la empresa seleccionada
        var empresa = document.getElementById("empresas").value;

        //Obtiene el centro de trabajo seleccionado
        var centroTrabajo = document.getElementById("centrosTrabajo").value;

        //Obtiene la fecha de inicio
        var fechaInicio = $("#fechaInicio").val();

        //Obtiene la fecha de inicio
        var fechaFin = $("#fechaFin").val();

        if(validarFormulario(centroTrabajo, fechaInicio, fechaFin)){
            //Genera el json
            var json = 
            {
                "idAlumno": alumno,
                "idTutorLaboral": tutorLaboral,
                "idEmpresa": empresa,
                "idCentroTrabajo": centroTrabajo,
                "fechaInicio": fechaInicio,
                "fechaFin": fechaFin
            };

            //Llama a la función para generar el PDF.
            generaPDF(json);
        } 
        else {
            alert("Comprueba los valores.");
        }
    });
});

function validarFormulario(centroTrabajo, fechaInicio, fechaFin){
    //Crea un booleano al que asignamos true por defecto
    var validar = true;

    //Hace invisible los errores si ya existían
    limpiarFormulario();

    //Obtiene el input de centrosTrabajo
    var centroTrabajoInput = document.getElementById("centrosTrabajo");

    //Obtiene el input de fechaInicio
    var fechaInicioInput = document.getElementById("fechaInicio");

    //Obtiene el input de fechaFin
    var fechaFinInput = document.getElementById("fechaFin");

    if(centroTrabajo == ""){
        //Cambia el borde a rojo
        centroTrabajoInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(fechaInicio == ""){
        //Cambia el borde a rojo
        fechaInicioInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(fechaFin == ""){
        //Cambia el borde a rojo
        fechaFinInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    return validar;
}

function limpiarFormulario(){
    //Obtiene el input de centrosTrabajo
    var centroTrabajoInput = document.getElementById("centrosTrabajo");

    //Obtiene el input de fechaInicio
    var fechaInicioInput = document.getElementById("fechaInicio");

    //Obtiene el input de fechaFin
    var fechaFinInput = document.getElementById("fechaFin");

    //Quita el borde rojo de centrosTrabajo
    centroTrabajoInput.classList.remove("borde-rojo");

    //Quita el borde rojo de centrosTrabajo
    fechaInicioInput.classList.remove("borde-rojo");

    //Quita el borde rojo de centrosTrabajo
    fechaFinInput.classList.remove("borde-rojo");
}

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

function generaPDF(json){
    //Llamada AJAX que se encarga de generar el PDF
    $.ajax(
        {
            url: "/API/generarPdf",
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(json), 
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                console.log(response);
            },
            error: function (xhr, status, error) {
                alert("Programa formativo generado perfectamente.");
                window.location.href = "/";
            }
        });
}

function personalizaDatePicker()
{
    //Indica que el input de fecha fin, esté deshabilitado
    $("#fechaFin").prop('disabled', true);

    //Creación de datapicker para las fechas
    //Crea el idioma español para datapicker ya que no está por defecto
    $.datepicker.regional['es'] = 
    {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd \'de\' MM \'de\' yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    
    //Indica el lenguaje de los datapicker que se usen
    $.datepicker.setDefaults($.datepicker.regional['es']);
    
    //Genera el datepicker de salida
    $("#fechaInicio").datepicker({minDate: 1});

    //Dentro de la condición del tipo de viaje idaVuelta
    $("#fechaInicio").on("change", function() 
    {
        //Obtiene el valor de la fecha de salida
        var fechaInicio = $("#fechaInicio").datepicker("getDate");

        //Suma 7 días a la fecha de salida
        fechaLimite = fechaInicio.getDate();

        //Crea datepicker y lo habilita de nuevo
        $("#fechaFin").prop('disabled', false).datepicker({minDate: fechaLimite});
    });
}