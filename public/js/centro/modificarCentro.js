//Espera a que la página cargue
$(function()
{
    //Lo introduce en el contenedor de easyadmin
    $(".content").append($("#modCentroTrabajo"));

    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Crear/Modificar Centro de Trabajo');

    //Hace la función del botón modificar
    $("#modificar").click(function(ev)
    {
        //Previene el submit que realiza por defecto
        ev.preventDefault();

        //Llama al método AJAX para modificar el centro
        guardarCentro();
    })
});

/**
 * 
 * @param {Email} email 
 * @param {String} telefono 
 * @param {String} direccion 
 * @returns 
 * Función que se encarga de validar los atributos pasados como parámetros.
 * Indica que no estén vacíos y que estén con la expresión requerida.
 */
function validarFormulario(email, telefono, direccion)
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
 * Función que llama a una api para realizar las modificaciones necesarias
 */
function guardarCentro()
{
    //Obtiene los datos del formulario
    var id = $("#id")[0].innerText; 
    var email = $("#email").val();
    var telefono = $("#telefono").val();
    var direccion = $("#direccion").val();   
    var fax = $("#fax").val();

    var json = 
    {
        "id": id,
        "email": email,
        "telefono": telefono,
        "direccion": direccion,
        "fax": fax
    };

    //Llamada AJAX que se encarga de insertar Ruta
    $.ajax(
        {
            url: "/API/modificarCentro",
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(json), 
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                window.location.href = "/admin?routeName=verCentros";
            }
        });
}