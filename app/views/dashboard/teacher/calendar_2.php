<?php require_once(__DIR__ . '/../../partials/header.php'); ?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>



<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-screen flex flex-col items-center justify-center py-6">


    <div class="container bg-white">
        <div id="calendar"></div>
    </div>


    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    // center: 'title',
                    right: 'title',
                },
                editable: true,
                selectable: true,
                selectHelper: true,
                events: 'fetch_events.php',

                // Ajouter une nouvelle présentation
                select: function(start) {
                    let id_etudiant = prompt("ID de l'étudiant :");
                    let id_presentation = prompt("ID de la présentation :");

                    if (id_etudiant && id_presentation) {
                        $.ajax({
                            url: "add_event.php",
                            type: "POST",
                            data: {
                                id_etudiant: id_etudiant,
                                id_presentation: id_presentation,
                                date: start.format()
                            },
                            success: function(response) {
                                $('#calendar').fullCalendar('refetchEvents');
                                alert(response);
                            }
                        });
                    }
                },

                // Supprimer une présentation en cliquant dessus
                eventClick: function(event) {
                    if (confirm("Supprimer cette présentation ?")) {
                        $.ajax({
                            url: "delete_event.php",
                            type: "POST",
                            data: {
                                id_presentation: event.id
                            },
                            success: function(response) {
                                $('#calendar').fullCalendar('refetchEvents');
                                alert(response);
                            }
                        });
                    }
                }
            });
        });
    </script>




</main>

<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>