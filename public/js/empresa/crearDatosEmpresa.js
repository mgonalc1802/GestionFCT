//Espera a que la página cargue
$(function()
{
    //Generar la acción del boton Generar
    document.getElementById('generar').addEventListener('click', function(ev){
        //Previene el submit que realiza por defecto
        ev.preventDefault();

        //Obtiene el alumno seleccionado
        var alumno = document.getElementById("alumno").value;

        //Obtiene el tutor laboral seleccionado
        var tutorLaboral = document.getElementById("tutorLaboral").value;

        //Obtiene la empresa seleccionada
        var empresa = document.getElementById("empresaSelect").value;

        //Obtiene el centro de trabajo seleccionado
        var centroTrabajo = document.getElementById("centroTrabajoSelect").value;

        //Obtiene la fecha de inicio
        var fechaInicio = $("#fechaInicio").val();

        //Obtiene el representante
        var idPersonaContacto = document.getElementById("representante").value;

        //Obtiene el profesor
        var profesor = document.getElementById("profesor").value;

        

        //Obtiene las horas del lunes
        var lunes = $("#lunes").val();

        //Obtiene las horas del martes
        var martes = $("#martes").val();

        //Obtiene las horas del miercoles
        var miercoles = $("#miercoles").val();

        //Obtiene las horas del jueves
        var jueves = $("#jueves").val();

        //Obtiene las horas del viernes
        var viernes = $("#viernes").val();

        //Obtiene el cursoEscolar
        var cursoEscolar = document.getElementById("cursoEscolar").value;

        if(validarFormulario(empresa, alumno, tutorLaboral, centroTrabajo, cursoEscolar, representante, profesor, lunes, martes, miercoles, jueves, viernes, fechaInicio)){
            //Genera el json
            var json = 
            {
                "idAlumno": alumno,
                "idTutorLaboral": tutorLaboral,
                "idEmpresa": empresa,
                "idCentroTrabajo": centroTrabajo,
                "fechaInicio": fechaInicio,
                "idProfesor": profesor,
                "idPersonaContacto": idPersonaContacto,
                'idCurso': cursoEscolar,
                'lunes': lunes,
                'martes': martes,
                'miercoles': miercoles,
                'jueves': jueves,
                'viernes': viernes,
            };

            //Llama a la función para generar el PDF.
            generaPDF(json);
        } 
        else {
            alert("Comprueba los valores.");
        }
    });
});

function validarFormulario(empresa, alumno, tutorLaboral, centroTrabajo, cursoEscolar, representante, profesor, lunes, martes, miercoles, jueves, viernes,fechaInicio){
    //Crea un booleano al que asignamos true por defecto
    var validar = true;

    //Hace invisible los errores si ya existían
    limpiarFormulario();

    //Obtiene el input de centrosTrabajo
    var empresaInput = document.getElementById("empresaSelect");

    //Obtiene el input de alumno
    var alumnoInput = document.getElementById("alumno");

    //Obtiene el input de alumno
    var tutorLaboralInput = document.getElementById("tutorLaboral");

    //Obtiene el input de centrosTrabajo
    var centroTrabajoInput = document.getElementById("centroTrabajoSelect");

    //Obtiene el input de cursosEscolares
    var cursoEscolarInput = document.getElementById("cursosEscolar");

    //Obtiene el input de representante
    var representanteInput = document.getElementById("representante");

    //Obtiene el input de profesor
    var profesorInput = document.getElementById("profesor");

    //Obtiene el input de lunes
    var lunesInput = document.getElementById("lunes");

    //Obtiene el input de martes
    var martesInput = document.getElementById("martes");

    //Obtiene el input de miercoles
    var miercolesInput = document.getElementById("miercoles");

    //Obtiene el input de jueves
    var juevesInput = document.getElementById("jueves");

    //Obtiene el input de lunes
    var viernesInput = document.getElementById("viernes");

    //Obtiene el input de fechaInicio
    var fechaInicioInput = document.getElementById("fechaInicio");

    if(empresa == ""){
        //Cambia el borde a rojo
        empresaInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(alumno == ""){
        //Cambia el borde a rojo
        alumnoInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(tutorLaboral == ""){
        //Cambia el borde a rojo
        tutorLaboralInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(centroTrabajo == ""){
        //Cambia el borde a rojo
        centroTrabajoInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(cursoEscolar == ""){
        //Cambia el borde a rojo
        cursoEscolarInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(representante == ""){
        //Cambia el borde a rojo
        representanteInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(profesor == ""){
        //Cambia el borde a rojo
        profesorInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(lunes == "" || lunes > 8 || lunes < 0){
        //Cambia el borde a rojo
        lunesInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(martes == "" || martes > 8 || martes < 0){
        //Cambia el borde a rojo
        martesInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(miercoles == "" || miercoles > 8 || miercoles < 0){
        //Cambia el borde a rojo
        miercolesInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(jueves == "" || jueves > 8 || jueves < 0){
        //Cambia el borde a rojo
        juevesInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(viernes == "" || viernes > 8 || viernes < 0){
        //Cambia el borde a rojo
        viernesInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    if(fechaInicio == ""){
        //Cambia el borde a rojo
        fechaInicioInput.classList.add("borde-rojo");

        //Cambia el booleano
        validar = false;
    }

    return validar;
}

function limpiarFormulario(){
    //Obtiene el input de empresaInput
    // var empresaInput = document.getElementById("empresaSelect");

    // //Quita el borde rojo de empresaInput
    // empresaInput.classList.remove("borde-rojo");

    // //Obtiene el input de alumno
    // var alumnoInput = document.getElementById("alumno");

    // //Quita el borde rojo de alumnoInput
    // alumnoInput.classList.remove("borde-rojo");

    // //Obtiene el input de tutorLaboralInput
    // var tutorLaboralInput = document.getElementById("tutorLaboral");

    // //Quita el borde rojo de tutorLaboralInput
    // tutorLaboralInput.classList.remove("borde-rojo");

    // //Obtiene el input de centrosTrabajo
    // var centroTrabajoInput = document.getElementById("centroTrabajoSelect");

    // //Quita el borde rojo de centrosTrabajo
    // centroTrabajoInput.classList.remove("borde-rojo");

    // //Obtiene el input de cursosEscolares
    // var cursoEscolarInput = document.getElementById("cursosEscolar");

    // //Quita el borde rojo de cursoEscolarInput
    // cursoEscolarInput.classList.remove("borde-rojo");

    // //Obtiene el input de representante
    // var representanteInput = document.getElementById("representante");

    // //Quita el borde rojo de representanteInput
    // representanteInput.classList.remove("borde-rojo");

    // //Obtiene el input de profesor
    // var profesorInput = document.getElementById("profesor");

    // //Quita el borde rojo de profesorInput
    // profesorInput.classList.remove("borde-rojo");

    // //Obtiene el input de lunes
    // var lunesInput = document.getElementById("lunes");

    // //Quita el borde rojo de lunesInput
    // lunesInput.classList.remove("borde-rojo");

    // //Obtiene el input de martes
    // var martesInput = document.getElementById("martes");

    // //Quita el borde rojo de martesInput
    // martesInput.classList.remove("borde-rojo");

    // //Obtiene el input de miercoles
    // var miercolesInput = document.getElementById("miercoles");

    // //Quita el borde rojo de miercolesInput
    // miercolesInput.classList.remove("borde-rojo");

    // //Obtiene el input de jueves
    // var juevesInput = document.getElementById("jueves");

    // //Quita el borde rojo de juevesInput
    // juevesInput.classList.remove("borde-rojo");

    // //Obtiene el input de viernes
    // var viernesInput = document.getElementById("viernes");

    // //Quita el borde rojo de viernesInput
    // viernesInput.classList.remove("borde-rojo");

    // //Obtiene el input de fechaInicio
    // var fechaInicioInput = document.getElementById("fechaInicio");

    // //Quita el borde rojo de fechaInicio
    // fechaInicioInput.classList.remove("borde-rojo");
}


function generaPDF(json){
    //Llamada AJAX que se encarga de generar el PDF
    $.ajax(
        {
            url: "/API/generarHojaEmpresa",
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(json), 
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                alert(response);
                window.location.href = "/";
            },
            error: function (xhr, status, error) {
                alert('Error: Los datos de esta empresa con el alumno ya existen.');
            }
        });
}
