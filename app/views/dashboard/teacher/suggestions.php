<?php require_once(__DIR__ . '/../../partials/header.php'); ?>




<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[600px]">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex justify-between">
            <h3 class="text-3xl font-extrabold text-gray-800 inline-block">Suggestions</h3>

            <!-- Search input -->
            <form method="GET">
                <div class="relative mx-4 lg:mx-0 border-b">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input type="text" name="userToSearch" onchange="this.form.submit()" class="w-32 pl-10 py-1 pr-4 rounded-md form-input sm:w-64 focus:border-indigo-600 focus:outline-none" placeholder="Search" value="<?= isset($_GET['userToSearch']) ? htmlspecialchars($_GET['userToSearch']) : '' ?>">
                </div>
            </form>

            <!-- Filter select -->
            <!-- <form method="GET">
                <select name="filter" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                    <option value="all" <?= isset($_GET['filter']) && $_GET['filter'] == 'all' ? 'selected' : '' ?>>ALL</option>
                    <option value="clients" <?= isset($_GET['filter']) && $_GET['filter'] == 'Enseignant' ? 'selected' : '' ?>>Enseignants</option>
                    <option value="freelancers" <?= isset($_GET['filter']) && $_GET['filter'] == 'Etudiant' ? 'selected' : '' ?>>Etudiants</option>
                </select>
            </form> -->
        </div>

        <div class="flex flex-col mt-8">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="inline-block min-w-full overflow-hidden align-middle border-b-2 border-indigo-600 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead class="bg-indigo-600 whitespace-nowrap">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-100 uppercase border-b-2 border-indigo-600 ">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-100 uppercase border-b-2 border-indigo-600 ">
                                    Description</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-100 uppercase border-b-2 border-indigo-600 ">
                                    Propose by</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-100 uppercase border-b-2 border-indigo-600 ">
                                    Status</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-right text-gray-100 uppercase border-b-2 border-indigo-600 ">
                                    Delete</th>
                            </tr>
                        </thead>

                        <tbody class="bg-indigo-50">
                            <!-- users -->
                            <?php foreach ($suggestions as $suggestion): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b-2 border-indigo-600">

                                        <div class="text-sm font-medium leading-5 text-gray-900"><?= htmlspecialchars($suggestion->titre); ?></div>

                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b-2 border-indigo-600">
                                        <div class="text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($suggestion->description); ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b-2 border-indigo-600">
                                        <?= $suggestion->id_etudiant; ?>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b-2 border-indigo-600">
                                        <?php if ($suggestion->status == 'Proposé') : ?>
                                            <form method="POST" action="/teacher/suggestions/changeStatus" style="display:inline;">
                                                <input type="hidden" name="status_sugg" value="<?= $suggestion->status; ?>">
                                                <input type="hidden" name="id_sugg" value="<?= $suggestion->id_sujet ?>">
                                                <button type="submit" name="btn_status_sugg" class="inline-flex px-2 text-xs font-semibold leading-5 bg-green-100 rounded-full text-blue-400">
                                                    <?= $suggestion->status ?>
                                                </button>
                                            </form>
                                        <?php elseif ($suggestion->status == 'Validé') : ?>
                                            <button name="btn_status_sugg" class="inline-flex px-2 text-xs font-semibold leading-5 bg-green-100 rounded-full text-green-400">
                                                <?= $suggestion->status ?>
                                            </button>
                                        <?php endif; ?>

                                    </td>



                                    <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b-2 border-indigo-600">
                                        <!-- Remove User Form with Confirmation -->
                                        <form method="POST" action="/teacher/suggestions/delete" style="display:inline;">
                                            <input type="hidden" name="id_delete" value="<?= $suggestion->id_sujet; ?>">
                                            <button type="submit" name="btn_delete_sugg" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>




<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>