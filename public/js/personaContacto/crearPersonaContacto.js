//Espera a que la página cargue
$(function()
{
    //Genera el botón de crearOther con las mismas características de EasyAdmin
    var crearOther = '<button class="crearOther btn btn-secondary" type="submit" value="crearOther" data-action-name="crearOther" form="new-Ruta-form">\
                        <span class="btn-label"><span class="action-label">Crear y Añadir Otro</span></span>\
                      </button>';

    //Genera el bot´pn CrearSalir con las mismas características de EasyAdmin
    var crearSalir = '<button class="crearSalir btn btn-primary action-save" type="submit" name="ea[newForm][btn]" value="saveAndReturn" data-action-name="saveAndReturn" form="new-User-form">\
                        <span class="btn-label"><span class="action-label">Crear</span></span>\
                      </button>';

    //Lo introduce en el contenedor de easyadmin
    $(".content").append($("#personaContacto"));

    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Crear Persona de Contacto');
    $(".page-actions").append(crearSalir);
    // $(".page-actions").append(crearOther);

    //Obtiene el botón
    var enviar = $(".crearSalir");

    //Evento del click
    enviar.click(function(ev)
    {
        //Previene el evento submit que tiene por defecto
        ev.preventDefault();

        //Obtiene los datos del formulario
        var nombre = $("#nombre").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();
        var telefono = $("#telefono").val();   

        //Si el formulario está correcto
        if(validarFormulario(nombre, telefono, apellido1))
        {
            //Genera el json
            var json = 
            {
                "nombre": nombre,
                "apellido1": apellido1,
                "apellido2": apellido2,
                "telefono": telefono
            };

            //Llama al método insertarRuta
            insertarPersonaContacto(json);
        }
    })
});

/**
 * 
 * @param {Email} nombre 
 * @param {String} telefono 
 * @param {String} apellido1 
 * @returns 
 * Función que se encarga de validar los atributos pasados como parámetros.
 * Indica que no estén vacíos y que estén con la expresión requerida.
 */
function validarFormulario(nombre, telefono, apellido1)
{
    //Crea un booleano al que asignamos true por defecto
    var validar = true;

    //Hace invisible los errores si ya existían
    quitarErrores();

    if(nombre == "")
    {
        //Muestra el error
        $("#errNombre").css("visibility", "visible");

        //Cambia el booleano
        validar = false;
    }

    //Expresión regular para 9 dígitos
    var regex = /^\d{9}$/;

    //Si las coordenadas está vacío
    if(!regex.test(telefono))
    {
        //Muestra el error
        $("#errTel").css("visibility", "visible");

        //Cambia el booleano
        validar = false;
    }

    if(apellido1 == "")
    {
        //Muestra el error
        $("#errApe1").css("visibility", "visible");

        //Cambia el booleano
        validar = false;
    }

    //Devuelve el booleano
    return validar;
}

/**
 * Función que hace desaparecer de la interfaz gráfica los errores.
 */
function quitarErrores()
{
    //Esconde todos los errores
    $(".errores").css("visibility", "hidden");
}


function insertarPersonaContacto(json) 
{
    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
    {
        url: "/API/crearPersonaContacto",
        type: 'POST',                                       
        dataType: 'json',
        data: JSON.stringify(json), 
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            alert("La persona de contacto ha sido creado con éxito. Su ID es " + response.idPersonaContacto);
            window.location.href = "/admin?routeName=verPersonasContacto";
        }
    });
}