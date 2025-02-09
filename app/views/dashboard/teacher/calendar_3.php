<?php require_once(__DIR__ . '/../../partials/header.php'); ?>



<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>



<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-screen flex flex-col items-center justify-center py-6">
    <div class="container flex justify-end py-4">
        <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Add en event
        </button>
    </div>
    <!-- Modale -->
    <div id="modal" class="hidden fixed inset-0 flex items-center justify-center bg-black">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <span class="close text-indigo-500 text-2xl cursor-pointer float-right">&times;</span>
            <h2 class="text-xl text-indigo-500 font-bold mb-4">Add a Presentation</h2>

            <form id="addEventForm" class="space-y-4">
                <div>
                    <label class="block text-gray-700">Title of Presentation :</label>
                    <select type="text" id="titre" class="w-full border p-2 rounded-lg" required>
                        <option value=""></option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Student 1 :</label>
                    <input type="number" id="etudiant1" class="w-full border p-2 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-gray-700">Student 2 :</label>
                    <input type="number" id="etudiant2" class="w-full border p-2 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-gray-700">Date :</label>
                    <input type="datetime-local" id="date" class="w-full border p-2 rounded-lg" required>
                </div>

                <button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600">
                    Add
                </button>
            </form>
        </div>
    </div>


    <div class="container bg-white">
        <div id="calendar"></div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("modal");
            const openModalBtn = document.getElementById("openModal");
            const closeModalBtn = document.querySelector(".close");

            openModalBtn.addEventListener("click", () => modal.classList.remove("hidden"));
            closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
            window.addEventListener("click", (e) => {
                if (e.target === modal) modal.classList.add("hidden");
            });

            // Soumission du formulaire
            document.getElementById("addEventForm").addEventListener("submit", function(e) {
                e.preventDefault();

                let titre = document.getElementById("titre").value;
                let etudiant1 = document.getElementById("etudiant1").value;
                let etudiant2 = document.getElementById("etudiant2").value;
                let date = document.getElementById("date").value;

                fetch("add_event.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `titre=${titre}&etudiant1=${etudiant1}&etudiant2=${etudiant2}&date=${date}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        modal.classList.add("hidden");
                        document.getElementById("addEventForm").reset();
                    });
            });
        });
    </script>


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
                    // let id_etudiant = prompt("ID de l'étudiant :");
                    // let id_presentation = prompt("ID de la présentation :");

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