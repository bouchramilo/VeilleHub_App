<?php
require_once(__DIR__ . '/../../partials/header.php'); ?>


<!-- <?php var_dump($calendarEvents) ?> -->
<!-- <?php var_dump($students) ?> -->
<!-- <?php var_dump($presentations) ?> -->


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
            events: <?php echo $calendarEvents; ?>,
            eventClick: function(info) {
                alert('Événement : ' + info.event.title);
            },
            dateClick: function(info) {
                document.getElementById('selectedDate').value = info.dateStr;
                document.getElementById('dateInput').value = info.dateStr;
                document.getElementById('modalForm').classList.remove('hidden');
            },
            
            // locale: 'fr',
        });

        calendar.render();
    });
</script>

<!-- Modal Form -->
<div id="modalForm" class="flex items-center justify-center bg-blue-100 bg-opacity-50 hidden px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4 text-indigo-600">Add an Event</h2>
        <form id="eventForm" action="/teacher/calendar/add" method="POST">
            <input type="hidden" id="selectedDate" name="date">

            <label class="block mb-2">Date :</label>
            <input type="date" id="dateInput" name="date" class="w-full border p-2 rounded-md" required readonly>

            <label class="block mb-2 mt-2">Title :</label>
            <select name="titre" class="w-full border p-2 rounded-md" required>
                <?php foreach ($presentations as $presentation) : ?>
                    <option value="<?= htmlspecialchars($presentation->id_presentation) ?>">
                        <?= htmlspecialchars($presentation->titre) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="block mt-2 mb-2">Students :</label>
            <select name="students[]" id="studentsPresentaion" class="w-full border p-2 rounded-md" multiple required>
                <?php foreach ($students as $student) : ?>
                    <option value="<?= htmlspecialchars($student->id_user) ?>">
                        <?= htmlspecialchars($student->nom . ' ' . $student->prenom) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="flex justify-between mt-4">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button type="submit" name="addToCalendrier" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Add</button>
            </div>
        </form>
    </div>
</div>


<main class="bg-blue-100 flex justify-center items-center py-6 px-4">
    <div id='calendar' class="container bg-white p-4 rounded-xl border-0"></div>
</main>






<script>
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('modalForm').classList.add('hidden'); // Cacher le modal
    });
</script>
<script>
    new MultiSelectTag("studentsPresentaion");
</script>

<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>