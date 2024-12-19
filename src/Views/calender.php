<?php ob_start(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',

            headerToolbar: {
                left: 'prev today next',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay multiMonthYear'
            },

            //Übersetzung
            locale: 'de',
            firstDay: 1,
            buttonText: {
                today: 'Heute',
                month: 'Monat',
                week: 'Woche',
                day: 'Tag',
                list: 'Liste',
                year: 'Jahr'
            },

            //Einträge im Kalender
            eventDisplay: 'block',
            events: '/api/getUserEvents',

            //Verschieben:
            editable: true,
            eventDrop: function(info) {
                alert('Event moved to: ' + info.event.start.toISOString());
            },
            //Klicken:
            eventClick: function(info) {
                alert('Event: ' + info.event.title + " um " + info.event.start.toISOString);
                info.jsEvent.preventDefault();
            },
            //Wochennummern
            weekNumbers: true,
            weekText: 'KW',
            eventContent: function (info) {
                // Customize how the event is displayed
                const event = info.event;

                // Create the main container
                let container = document.createElement('div');
                container.className = 'fc-event-main';

                // Add event title
                let title = document.createElement('div');
                title.textContent = event.title;
                container.appendChild(title);

                // Add event location if available
                if (event.extendedProps.location) {
                    let location = document.createElement('div');
                    location.textContent = `📍 ${event.extendedProps.location}`;
                    location.className = 'fc-event-location';
                    container.appendChild(location);
                }

                return { domNodes: [container] };
            }
        });
        calendar.render();
    });

</script>

<div id='calendar' class="calender"></div>

<?php 
    $content = ob_get_clean();
    include 'inc/layout.php';
?>