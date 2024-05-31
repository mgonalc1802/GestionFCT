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
    $(".content").append($("#centroTrabajo"));

    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Crear Centro de Trabajo');
    $(".page-actions").append(crearSalir);
    // $(".page-actions").append(crearOther);

    //Inserta datos en el select de Provincias
    traeProvincias();

    //Obtiene el select de provincias
    selectProvi = document.getElementById('provincias');

    //Cuando el select de Provincias cambie
    selectProvi.addEventListener("change", function()
    {
        //Busca las localidades de dicha localidad
        traeLocalidades(this.options[this.selectedIndex].value); 
    })

    //Obtiene el botón
    var enviar = $(".crearSalir");

    //Evento del click
    enviar.click(function(ev)
    {
        //Previene el evento submit que tiene por defecto
        ev.preventDefault();

        //Obtiene los datos del formulario
        var email = $("#email").val();
        var telefono = $("#telefono").val();   
        var direccion = $("#direccion").val();
        var fax = $("#fax").val();
        var localidad = $("#localidades option:selected").val();

        //Si el formulario está correcto
        if(validarFormulario(email, telefono, direccion, localidad))
        {
            //Genera el json
            var json = 
            {
                "email": email,
                "telefono": telefono,
                "direccion": direccion,
                "fax": fax,
                "localidad": localidad
            };

            //Llama al método insertarRuta
            insertarPersonaContacto(json);
        }
    })
});

/**
 * 
 * @param {Email} email 
 * @param {String} telefono 
 * @param {String} direccion 
 * @param {String} localidad 
 * @returns 
 * Función que se encarga de validar los atributos pasados como parámetros.
 * Indica que no estén vacíos y que estén con la expresión requerida.
 */
function validarFormulario(email, telefono, direccion, localidad)
{
    //Crea un booleano al que asignamos true por defecto
    var validar = true;

    //Hace invisible los errores si ya existían
    quitarErrores();

    //Si título es vacío
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if(email == "" || !emailRegex.test(email))
    {
        //Muestra el error
        $("#errEmail").css("visibility", "visible");

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

    if(direccion == "")
    {
        //Muestra el error
        $("#errDir").css("visibility", "visible");

        //Cambia el booleano
        validar = false;
    }

    console.log(localidad)

    if(localidad == null)
    {
        //Muestra el error
        $("#errLoc").css("visibility", "visible");

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


/**
 * 
 * @param {String} provincia.
 * Ejecuta un AJAX para traer las localidades de una provincia concreta.
 * Cada vez que se llame, lo vacía para no mezclar localidades.
 */
function traeLocalidades(provincia)
{
    //Obtiene el contenido html necesario
    var selectLocalid = $("#localidades");

    //Vacía el select
    selectLocalid.empty();

    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
    {
        url: "/API/localidades/" + provincia,
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            //Borra el atributo disabled
            selectLocalid.removeAttr('disabled');

            //Recorre el array que obtiene a través de la API
            for(let i = 0; i < response.length; i++)
            {
                //Crea un nuevo elemento del select
                var option = $('<option value = "' + response[i].nombre + '">' + response[i].nombre + '</option>');

                //Añade al select la opción
                selectLocalid.append(option);
            }       
        }
    });
}

function traeProvincias()
{
    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
    {
        url: "/API/provincias",
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            //Obtiene el contenido html necesario
            var selectProvi = $("#provincias");

            //Recorre el array que obtiene a través de la API
            for(let i = 0; i < response.length; i++)
            {
                //Crea un nuevo elemento del select
                var option = $('<option value = "' + response[i].nombre + '">' + response[i].nombre +'</option>');

                //Añade al select la opción
                selectProvi.append(option);
            }       
        }
    });
}

function insertarPersonaContacto(json) 
{
    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
    {
        url: "/API/crearCentro",
        type: 'POST',                                       
        dataType: 'json',
        data: JSON.stringify(json), 
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            alert("El centro de trabajo ha sido creado con éxito. Su ID es " + response.idCentro);
            window.location.href = "/admin?routeName=verCentros";
        }
    });
}