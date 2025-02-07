<?php require_once(__DIR__ . '/../../partials/header.php'); ?>






<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-screen flex flex-col items-center justify-center py-6">
    <!-- <div class="container px-6 py-8 mx-auto"> -->
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Calendar</h3>
    <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> -->
    <div class="response"></div>
    <div id='calendar' class="container bg-white  h-full shadow-xl rounded-lg px-6 py-8 mx-auto"></div>
    <!-- </div> -->
    <!-- </div>-->
</main>

<script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: "fetch-event.php",
            displayEventTime: false,
            eventRender: function(event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');

                if (title) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                    $.ajax({
                        url: 'add-event.php',
                        data: 'title=' + title + '&start=' + start + '&end=' + end,
                        type: "POST",
                        success: function(data) {
                            displayMessage("Added Successfully");
                        }
                    });
                    calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true
                    );
                }
                calendar.fullCalendar('unselect');
            },

            editable: true,
            eventDrop: function(event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                $.ajax({
                    url: 'edit-event.php',
                    data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                    type: "POST",
                    success: function(response) {
                        displayMessage("Updated Successfully");
                    }
                });
            },
            eventClick: function(event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: "delete-event.php",
                        data: "&id=" + event.id,
                        success: function(response) {
                            if (parseInt(response) > 0) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                displayMessage("Deleted Successfully");
                            }
                        }
                    });
                }
            }

        });
    });

    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        })
        calendar.render()
    })
</script>



<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>