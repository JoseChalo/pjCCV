var calendarEl = document.getElementById('calendar')
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    buttonText: {
        today: "Hoy",
        month: "Mes",
        week: "Semana",
        day: "D\xEDa",
        list: "Agenda"
    },
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    locale: 'es',
    events: 'getEventos.php',
    dayMaxEvents: true,
    navLinks: true,
    eventClick: function(info) {
        var idEvento = info.event.extendedProps.idEvento;
        var idTipo = info.event.extendedProps.idTipo;
        window.location.href = 'verEvento.php?idEvento=' + idEvento + '&idTipo=' + idTipo
    }
});

calendar.render();