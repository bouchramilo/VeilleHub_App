<?php require_once(__DIR__ . '/../partials/header.php'); ?>




<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: <?php echo $calendarEvents; ?>, // Insérer les données PHP dans le script JS
            eventClick: function(info) {
                alert('Événement : ' + info.event.title);
            },
            locale: 'fr',
        });

        calendar.render();
    });
</script>

<main class="bg-blue-100 flex justify-center items-center py-6 px-4">
    <div id='calendar' class="container bg-white py-6 px-4 rounded-lg"></div>
</main>


<?php require_once(__DIR__ . '/../partials/footer.php'); ?>