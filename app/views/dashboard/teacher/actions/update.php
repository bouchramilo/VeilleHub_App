<?php require_once(__DIR__ . '/../../../partials/header.php'); ?>





<main class="flex flex-col justify-center items-center min-h-screen bg-blue-100 py-6 px-4">

    <!-- model add subject  -->
    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 ">
        <div class="flex items-center">
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Add a topic</h3>
        </div>

        <form method="post" action="/teacher/actions/update/save" class="space-y-4 mt-8">
            <input type="hidden" name="id_presentation_update" value="<?= $subject->id_presentation; ?>">
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Title</label>
                <input type="text" placeholder="Enter Title of topic" name="titre" value="<?= $subject->titre; ?>"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required />
            </div>
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Description</label>
                <textarea type="text" placeholder="Enter Description of topic" name="description"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg resize-none" required><?= $subject->description; ?></textarea>
            </div>
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Status</label>
                <select id="status" name="status" class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required>
                    <option value="">-- Select a Status --</option>
                    <option value="A venir" <?php if ($subject->status == "A venir") {
                                                echo 'selected';
                                            }; ?>>A venir</option>
                    <option value="Passé" <?php if ($subject->status == "Passé") {
                                                echo 'selected';
                                            }; ?>>Passé</option>
                </select>
            </div>
            <div id="link_container">
                <label class="text-gray-800 text-sm mb-1 block">Link of presentation</label>
                <input id="lien_presentation" type="url" placeholder="Enter lien of topic" name="lien" value="<?= $subject->lien_presentation; ?>"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" />
            </div>

            <div>
                <label class="text-gray-800 text-sm mb-1 block">Date</label>
                <input type="date" placeholder="Enter date of topic" name="date" value=""
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required />
            </div>

            <div class="flex justify-end gap-4 !mt-8">
                <button name="btn_update_subject" class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-indigo-600 hover:bg-indigo-500">Save</button>
            </div>
        </form>
    </div>

</main>






<script>
    document.addEventListener("DOMContentLoaded", function() {
        let statusSelect = document.getElementById("status");
        let linkContainer = document.getElementById("link_container");

        function toggleLinkInput() {
            if (statusSelect.value === "Passé") {
                linkContainer.style.display = "block";
            } else {
                linkContainer.style.display = "none";
            }
        }

        toggleLinkInput();

        statusSelect.addEventListener("change", toggleLinkInput);
    });
</script>




<?php require_once(__DIR__ . '/../../../partials/footer.php'); ?>