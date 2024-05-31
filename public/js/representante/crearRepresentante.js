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
    $(".content").append($("#representante"));

    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Crear Representante');
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
        var dni = $("#dni").val();
        var nombre = $("#nombre").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();
        var cargo = $("#cargo").val();   

        //Si el formulario está correcto
        if(validarFormulario(dni, nombre, cargo, apellido1))
        {
            //Genera el json
            var json = 
            {
                "dni": dni,
                "nombre": nombre,
                "apellido1": apellido1,
                "apellido2": apellido2,
                "cargo": cargo
            };

            //Llama al método insertarRuta
            insertarRepresentante(json);
        }
    })
});

/**
 * 
 * @param {String} dni 
 * @param {String} nombre 
 * @param {String} cargo 
 * @param {String} apellido1 
 * @returns 
 * Función que se encarga de validar los atributos pasados como parámetros.
 * Indica que no estén vacíos y que estén con la expresión requerida.
 */
function validarFormulario(dni, nombre, cargo, apellido1)
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

    if(cargo == "")
    {
        //Muestra el error
        $("#errCargo").css("visibility", "visible");

        //Cambia el booleano
        validar = false;
    }

    //Si las coordenadas está vacío
    if(!validarDNI(dni) || dni == "")
    {
        //Muestra el error
        $("#errDni").css("visibility", "visible");

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


function insertarRepresentante(json) 
{
    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
    {
        url: "/API/crearRepresentante",
        type: 'POST',                                       
        dataType: 'json',
        data: JSON.stringify(json), 
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            alert("El representante ha sido creado con éxito. Su ID es " + response.idRepresentante);
            window.location.href = "/admin?routeName=verRepresentantes";
        }
    });
}

function validarDNI(dni) {
    //Obtiene la letra del dni
    const letra = dni.slice(-1);

    //Obtiene los numeros del dni
    const numeros = dni.slice(0, -1);

    //Genera una condición realizando los cálculos necesarios para saber si el dni es válido
    const letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";

    //Genera una condición realizando los cálculos necesarios para saber si el dni es válido
    if (letrasValidas.charAt(numeros % 23) === letra && letra.length === 1 && numeros.length === 8) {
        //Devuelve true, indicando que el dni es correcto
        return true;
    }

    //Devuelve false, indicando que el dni es incorrecto
    return false;
}