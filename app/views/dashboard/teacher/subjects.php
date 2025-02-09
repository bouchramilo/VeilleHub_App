<?php require_once(__DIR__ . '/../../partials/header.php'); ?>





<div class=" font-[sans-serif] p-4 min-h-screen bg-blue-200">
    <div class="max-w-6xl mx-auto">
        <div class="w-full flex flex-col justify-between">
            <div class="flex justify-between">
                <h3 class="text-3xl font-extrabold text-gray-800 inline-block">Subjects</h3>

                <!-- Search input -->
                <form method="GET">
                    <div class="relative mx-4 lg:mx-0 border-b">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <input type="text" name="subToSearch" onchange="this.form.submit()" class="w-32 pl-10 py-1 pr-4 rounded-md form-input sm:w-64 focus:border-indigo-600 focus:outline-none" placeholder="Search" value="<?= isset($_GET['userToSearch']) ? htmlspecialchars($_GET['userToSearch']) : '' ?>">
                    </div>
                </form>

                <!-- Filter select -->
                <form method="GET">
                    <select name="filter" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                        <option value="all" <?= isset($_GET['filter']) && $_GET['filter'] == 'all' ? 'selected' : '' ?>>ALL</option>
                        <option value="A venir" <?= isset($_GET['filter']) && $_GET['filter'] == 'A venir' ? 'selected' : '' ?>>A venir</option>
                        <option value="Passé" <?= isset($_GET['filter']) && $_GET['filter'] == 'Passé' ? 'selected' : '' ?>>Passé</option>
                    </select>
                </form>
            </div>
            <div class="flex justify-end">
                <button class="addSubjects px-4 py-2 h-14 w-max border-0 rounded-md bg-indigo-600 hover:border-indigo-500 hover:bg-transparent hover:border-2 text-white hover:text-indigo-600">
                    Add subject
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-12 max-lg:max-w-3xl max-md:max-w-md mx-auto ">

            <?php foreach ($subjects as $subject): ?>
                <div class="p-6 bg-indigo-600 bg-opacity-50 border-none rounded-xl flex flex-col justify-between shadow-2xl shadow-black hover:shadow-xl">
                    <span class="text-sm block mb-2 text-black font-semibold"><?= $subject->date_realisation; ?> | Status : <?= $subject->status; ?></span>
                    <h3 class="text-xl font-bold text-white"><?= $subject->titre; ?></h3>
                    <div class="mt-4">
                        <p class="text-gray-200 text-sm "><?= $subject->description; ?></p>
                    </div>
                    <div class="flex justify-end">
                        <div class="flex gap-4">
                            <a href="/teacher/subject/update?id=<?= $subject->id_presentation; ?>" class="w-full flex justify-end">
                                <!-- <input type="hidden" name="id_update" value="<?= $subject->id_presentation; ?>"> -->
                                <button name="btn_update_subject">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-blue-500 hover:fill-blue-700"
                                        viewBox="0 0 348.882 348.882">
                                        <path
                                            d="m333.988 11.758-.42-.383A43.363 43.363 0 0 0 304.258 0a43.579 43.579 0 0 0-32.104 14.153L116.803 184.231a14.993 14.993 0 0 0-3.154 5.37l-18.267 54.762c-2.112 6.331-1.052 13.333 2.835 18.729 3.918 5.438 10.23 8.685 16.886 8.685h.001c2.879 0 5.693-.592 8.362-1.76l52.89-23.138a14.985 14.985 0 0 0 5.063-3.626L336.771 73.176c16.166-17.697 14.919-45.247-2.783-61.418zM130.381 234.247l10.719-32.134.904-.99 20.316 18.556-.904.99-31.035 13.578zm184.24-181.304L182.553 197.53l-20.316-18.556L294.305 34.386c2.583-2.828 6.118-4.386 9.954-4.386 3.365 0 6.588 1.252 9.082 3.53l.419.383c5.484 5.009 5.87 13.546.861 19.03z"
                                            data-original="#000000" />
                                        <path
                                            d="M303.85 138.388c-8.284 0-15 6.716-15 15v127.347c0 21.034-17.113 38.147-38.147 38.147H68.904c-21.035 0-38.147-17.113-38.147-38.147V100.413c0-21.034 17.113-38.147 38.147-38.147h131.587c8.284 0 15-6.716 15-15s-6.716-15-15-15H68.904C31.327 32.266.757 62.837.757 100.413v180.321c0 37.576 30.571 68.147 68.147 68.147h181.798c37.576 0 68.147-30.571 68.147-68.147V153.388c.001-8.284-6.715-15-14.999-15z"
                                            data-original="#000000" />
                                    </svg>
                                </button>
                            </a>
                            <form action="/teacher/subject/delete" method="post" class="w-full flex justify-end">
                                <input type="hidden" name="id_delete" value="<?= $subject->id_presentation; ?>">
                                <button name="btn_delete_subject">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-red-500 hover:fill-red-700" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                            data-original="#000000" />
                                        <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                            data-original="#000000" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</div>



<!-- model add subject  -->
<div
    class="addSubModal hidden fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
    <div class="w-full max-w-lg bg-yellow-50 shadow-lg rounded-lg p-8 relative">
        <div class="flex items-center">
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Add a topic</h3>
        </div>

        <form method="post" action="/teacher/subjects/add" class="space-y-4 mt-8">
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Title</label>
                <input type="text" placeholder="Enter Title of topic" name="titre" value=""
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required />
            </div>
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Description</label>
                <textarea type="text" placeholder="Enter Description of topic" name="description"
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg resize-none" required></textarea>
            </div>
            <div>
                <label class="text-gray-800 text-sm mb-1 block">Date</label>
                <input type="date" placeholder="Enter date of topic" name="date" value=""
                    class="px-4 py-3 bg-indigo-100 w-full text-gray-800 text-sm border-none focus:outline-indigo-600 focus:bg-transparent rounded-lg" required />
            </div>

            <div class="flex justify-end gap-4 !mt-8">
                <button type="button"
                    class="close px-6 py-3 rounded-lg text-gray-800 text-sm border-none outline-none tracking-wide bg-indigo-200 hover:bg-indigo-300">cancel</button>
                <button type="submit" name="btn_add_subject" value=""
                    class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-indigo-600 hover:bg-indigo-500">Add</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addSubjects = document.querySelector(".addSubjects");
    const close = document.querySelector(".close");
    const addSubModal = document.querySelector(".addSubModal");
    addSubjects.addEventListener("click", () => {
        addSubModal.classList.toggle("hidden");
    });
    close.addEventListener("click", () => {
        addSubModal.classList.toggle("hidden");
    });
</script>



<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>