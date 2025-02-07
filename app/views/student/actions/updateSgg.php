<?php require_once(__DIR__ . '/../../partials/header.php'); ?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[600px] flex justify-center items-center">

<!-- ********************************************************************************************************************************************************************** -->


    <div class="w-full max-w-lg bg-yellow-50 shadow-lg rounded-lg p-8 relative">
        <div class="flex items-center">
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Modify a topic</h3>
        </div>

        <form method="post" action="/student/my_suggestions/update" class="space-y-4 mt-8">
            <input type="hidden" name="id_sujet" value="<?= $suggestion[0]; ?>">
            <div>
                <label class="text-gray-800 text-sm mb-1 block">New Title</label>
                <input type="text" placeholder="Enter Title of topic" name="titre" value="<?= $suggestion[1]; ?>"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required />
            </div>
            <div>
                <label class="text-gray-800 text-sm mb-1 block">New Description</label>
                <textarea type="text" placeholder="Enter Description of topic" name="description"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg resize-none" required><?= $suggestion[2]; ?></textarea>
            </div>
            <div class="flex justify-end gap-4 !mt-8">
                <!-- <button type="button"
                    class="close px-6 py-3 rounded-lg text-gray-800 text-sm border-none outline-none tracking-wide bg-indigo-200 hover:bg-indigo-300">cancel</button> -->
                <button type="submit" name="btn_update_sugg" value=""
                    class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-indigo-600 hover:bg-indigo-500">Save</button>
            </div>
        </form>
    </div>




<!-- ********************************************************************************************************************************************************************** -->

</main>

<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>