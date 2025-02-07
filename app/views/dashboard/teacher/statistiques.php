<?php require_once(__DIR__ . '/../../partials/header.php'); ?>


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[600px]">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex flex-col justify-between">
            <h3 class="text-3xl font-extrabold text-gray-800 inline-block">Statistics</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 ">

                <div class="bg-indigo-500 text-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold">Total des Présentations</h2>
                    <p class="text-3xl font-bold mt-2"><?= $statistics[0]; ?></p>
                </div>


                <div class="bg-indigo-500 text-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold">Étudiant le plus actif</h2>
                    <p class="text-lg mt-2">👨‍🎓 <?= $statistics[2][0]['nom'] . ' ' . $statistics[2][0]['prenom']; ?></p>
                    <p class="text-3xl font-bold"><?= $statistics[2][0]['nombre_sujets']; ?> sujets</p>
                </div>


                <div class="bg-indigo-500 text-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold">Taux de Participation</h2>
                    <p class="text-3xl font-bold mt-2"><?= $statistics[1]; ?>%</p>
                </div>
            </div>


            <div class="mt-6 p-6 rounded-lg ">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Étudiants les plus actifs</h2>
                <table class="w-full border-collapse border-gray-300 bg-indigo-100 border rounded-lg shadow-lg">
                    <thead class="bg-indigo-500 text-white">
                        <tr>
                            <th class="border-0 border-b-2 border-indigo-500 p-2">Nom</th>
                            <th class="border-0 border-b-2 border-indigo-500 p-2">Prénom</th>
                            <th class="border-0 border-b-2 border-indigo-500 p-2">Nombre de Sujets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statistics[2] as $user): ?>
                            <tr class="">
                                <td class="border-0 border-b-2 border-indigo-500 p-2 text-center"><?= $user['nom']; ?></td>
                                <td class="border-0 border-b-2 border-indigo-500 p-2 text-center"><?= $user['prenom']; ?></td>
                                <td class="border-0 border-b-2 border-indigo-500 p-2 text-center"><?= $user['nombre_sujets']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>




<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>