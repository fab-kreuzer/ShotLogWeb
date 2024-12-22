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
            events: async function (info, successCallback, failureCallback) {
                try {
                    // Fetch user events
                    let userEventsResponse = await fetch('/api/getUserEvents');
                    let userEvents = await userEventsResponse.json();

                    // Fetch Bavarian holidays
                    let holidaysResponse = await fetch('https://feiertage-api.de/api/?jahr=2024&nur_land=BY');
                    let holidaysData = await holidaysResponse.json();

                    // Convert holidays to FullCalendar format
                    let holidayEvents = Object.keys(holidaysData).map(key => {
                        return {
                            title: key,
                            start: holidaysData[key].datum,
                            allDay: true,
                            color: '#96831f',
                            extendedProps: {
                                additionalInfo: holidaysData[key].hinweis,
                            }
                        };
                    });
                    console.log(holidayEvents);
                    // Combine user events and holidays
                    successCallback([...userEvents, ...holidayEvents]);
                } catch (error) {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                }
            },

            //Verschieben:
            editable: true,
            eventDrop: function(info) {
                const sessionId = info.event.id;
                const newTime = info.event.start.toISOString();
                fetch('/updateTime', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ sessionId, newTime }),
                }).catch(error => {
                    console.error('Error updating event:', error);
                    alert('An error occurred while updating the event.');
                });
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

                    const timeElement = document.createElement('div'); // Create a new div or span for the time
                    timeElement.textContent = `🕒 ${event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} Uhr`;
                    location.appendChild(timeElement);

                    location.className = 'fc-event-location';
                    location.style.marginTop = '4px;';
                    container.appendChild(location);
                }

                if (event.extendedProps.additionalInfo) {
                    let location = document.createElement('div');
                    location.textContent = `${event.extendedProps.additionalInfo}`;
                    location.className = 'fc-event-location';
                    location.style.marginTop = '4px;';
                    container.appendChild(location);
                }

                return { domNodes: [container] };
            },
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Monday to Friday
                startTime: '08:00', // Start time
                endTime: '18:00',   // End time
            }
        });

        document.addEventListener('keydown', function(e) {
            switch (e.key) {
                case 'ArrowLeft':
                    calendar.prev();
                    break;
                case 'ArrowRight':
                    calendar.next();
                    break;
                case 't':
                    calendar.today();
                    break;
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