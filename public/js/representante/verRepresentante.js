//Espera a que la página cargue
$(function()
{
    var crear = '<a class=" action-new btn btn-primary" href="/admin?routeName=representantes" data-action-name="new"><span class="action-label">Add Representante</span></a>';
                      
    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Representante');
    $(".page-actions").append(crear);

    //Oculta los botones
    $(".global-actions").css("visibility", "hidden");

    //Obtiene el div
    var representante = $("#verRepresentantes");

    //Lo introduce en el contenedor de easyadmin
    $(".content").append(representante);

    //Llama al método que trae los centros de trabajo
    traeRepresentantes();
});

/**
 * Método que trae todos los centros y los muestra en una tabla
 */
function traeRepresentantes()
{
    //Llamada AJAX que se encarga de insertar Centro
    $.ajax(
    {
        url: "/API/representantes",
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json', 
        processData: false,
        success: function (response) 
        {
            //Obtiene el contenido html necesario
            var tablaRepresentante = $("tbody");

            //Recorre el array que obtiene a través de la API
            for(let i = 0; i < response.length; i++)
            {
                //Crea una fila elemento para tbody
                var tr = $('<tr data-id="' + response[i].id + '">');

                //Crea una columna para la fila
                var tdDni = $('<td data-column="dni" data-label="dni" class=" text- field-text" dir="ltr">\
                                    <span title="' + response[i].dni + '">' + response[i].dni + '</a>\
                                 </td>');

                var tdNombre = $('<td data-column="nombre" data-label="Nombre" class=" text- field-text" dir="ltr">\
                                    <span title="' + response[i].nombre + '">' + response[i].nombre + '</a>\
                                 </td>');
                
                var tdApellido1 = $('<td data-column="apellido1" data-label="Primer Apellido" class=" text- field-text" dir="ltr">\
                                        <span title="' + response[i].apellido1 + '">' + response[i].apellido1 + '</span>\
                                    </td>');

                var tdApellido2 = $('<td data-column="direccion" data-label="Segundo Apellido" class=" text- field-text" dir="ltr">\
                                        <span title="' + response[i].apellido2 + '">' + response[i].apellido2 + '</span>\
                                    </td>');

                var tdCargo = $('<td data-column="cargo" data-label="Cargo" class=" text- field-text" dir="ltr">\
                                    <span title="' + response[i].cargo + '">' + response[i].cargo + '</span>\
                                </td>');

                var tdAcciones = $('<td class="actions actions-as-dropdown">\
                                        <div class="dropdown dropdown-actions">\
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                                                <svg xmlns="http://www.w3.org/2000/svg" height="21" width="21" fill="none" viewBox="0 0 24 24" stroke="currentColor">\
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>\
                                                </svg>\
                                            </a>\
                                            <div class="dropdown-menu dropdown-menu-right">\
                                                <a class="dropdown-item action-edit" href="/modificarRepresentante/' + response[i].id + '" data-action-name="edit"><span class="action-label">Edit</span></a>\
                                                <a class="dropdown-item action-delete text-danger" onclick = "borrarRepresentante(' + response[i].id + ')" data-action-name="delete"><span class="action-label">Delete</span></a>\
                                            </div>\
                                        </div>\
                                    </td>');

                //Añade al tr sus datos necesarios
                tr.append(tdDni);
                tr.append(tdNombre);
                tr.append(tdApellido1);
                tr.append(tdApellido2);
                tr.append(tdCargo);
                tr.append(tdAcciones);

                //Añade al select la opción
                tablaRepresentante.append(tr);
            }       
        }
    });
}

function borrarRepresentante(id)
{
    $.ajax(
        {
            url: "/API/borrarRepresentante/" + id,
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json', 
            processData: false,
            success: function (response) 
            {
                alert(response);
                window.location.href = "/admin?routeName=verRepresentantes";
            }
        });
}