$(function()
{
    //Obtiene el div
    var calendarioAdmin = $("#calendarioAdmin");

    //Lo introduce en el contenedor de easyadmin
    $(".content").append(calendarioAdmin);

    //Obtiene el header de la plantilla de easyAdmin
    $(".content-header-title h1").append('Calendario');

    //Obtiene el calendario del html
    var calendarEl = document.getElementById('calendar');

    //Crea un FullCalendar
    var calendar = new FullCalendar.Calendar(calendarEl, 
    {
        timeZone: 'GMT+1',
        themeSystem: 'bootstrap5',
        headerToolbar: 
        {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        weekNumbers: true,
        dayMaxEvents: true,
    });

    //Muestra el calencario
    calendar.render();
});
