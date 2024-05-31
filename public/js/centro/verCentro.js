//Espera a que la página cargue
$(function()
{
    var crear = '<a class=" action-new btn btn-primary" href="/admin?routeName=centros" data-action-name="new"><span class="action-label">Add Centro</span></a>';
                      
    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Centros');
    $(".page-actions").append(crear);

    //Oculta los botones
    $(".global-actions").css("visibility", "hidden");

    //Obtiene el div
    var centro = $("#verCentro");

    //Lo introduce en el contenedor de easyadmin
    $(".content").append(centro);

    //Llama al método que trae los centros de trabajo
    traeCentros();
});

/**
 * Método que trae todos los centros y los muestra en una tabla
 */
function traeCentros()
{
    //Llamada AJAX que se encarga de insertar Centro
    $.ajax(
    {
        url: "/API/centros",
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            //Obtiene el contenido html necesario
            var tablaCentro = $("tbody");

            //Recorre el array que obtiene a través de la API
            for(let i = 0; i < response.length; i++)
            {
                //Crea una fila elemento para tbody
                var tr = $('<tr data-id="' + response[i].id + '">');

                //Crea una columna para la fila
                var tdEmail = $('<td data-column="email" data-label="Email" class=" text- field-text" dir="ltr">\
                                    <span title="' + response[i].email + '">' + response[i].email + '</a>\
                                 </td>');
                
                var tdTelefono = $('<td data-column="telefono" data-label="Telefono" class=" text- field-text" dir="ltr">\
                                        <span title="' + response[i].telefono + '">' + response[i].telefono + '</span>\
                                    </td>');

                var tdDireccion = $('<td data-column="direccion" data-label="Direccion" class=" text- field-text" dir="ltr">\
                                        <span title="' + response[i].direccion + '">' + response[i].direccion + '</span>\
                                    </td>');

                var tdFax= $('<td data-column="fax" data-label="Fax" class=" text- field-text" dir="ltr">\
                                    <span title="' + response[i].fax + '">' + response[i].fax + '</span>\
                                </td>');
                
                var tdLocalidad = $('<td data-column="localidad" data-label="Localidad" class=" text-center field-text" dir="ltr">\
                                        <span title="' + response[i].localidad + '">' + response[i].localidad + '</span>\                                    </a>\
                                </td>');

                var tdAcciones = $('<td class="actions actions-as-dropdown">\
                                        <div class="dropdown dropdown-actions">\
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                                                <svg xmlns="http://www.w3.org/2000/svg" height="21" width="21" fill="none" viewBox="0 0 24 24" stroke="currentColor">\
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>\
                                                </svg>\
                                            </a>\
                                            <div class="dropdown-menu dropdown-menu-right">\
                                                <a class="dropdown-item action-edit" href="/modificarCentro/' + response[i].id + '" data-action-name="edit"><span class="action-label">Edit</span></a>\
                                                <a class="dropdown-item action-delete text-danger" onclick = "borrarCentro(' + response[i].id + ')" data-action-name="delete"><span class="action-label">Delete</span></a>\
                                            </div>\
                                        </div>\
                                    </td>');

                //Añade al tr sus datos necesarios
                tr.append(tdEmail);
                tr.append(tdTelefono);
                tr.append(tdDireccion);
                tr.append(tdFax);
                tr.append(tdLocalidad);
                tr.append(tdAcciones);

                //Añade al select la opción
                tablaCentro.append(tr);
            }       
        }
    });
}

function borrarCentro(id)
{
    $.ajax(
        {
            url: "/API/borrarCentro/" + id,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                alert(response);
                window.location.href = "/admin?routeName=verCentros";
            }
        });
}