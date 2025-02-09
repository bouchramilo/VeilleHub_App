<?php require_once(__DIR__ . '/../partials/header.php'); ?>


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[600px] py-6">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">📊 Statistiques Étudiant</h1>

        <!-- nbr de suggestions -->
        <div class="bg-blue-100 p-4 rounded-lg shadow-md mb-4">
            <p class="text-lg font-semibold text-blue-800">Nombre de suggestions :</p>
            <p class="text-3xl font-bold text-blue-900" id="totalSuggestions"><?= $statistics['total_suggestions']; ?></p>
        </div>

        <!-- présentations -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="bg-green-100 p-4 rounded-lg shadow-md">
                <p class="text-lg font-semibold text-green-800">Présentations à venir :</p>
                <p class="text-3xl font-bold text-green-900" id="presentationsAvenir"><?= $statistics['presentations_A_venir']; ?></p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg shadow-md">
                <p class="text-lg font-semibold text-red-800">Présentations passées :</p>
                <p class="text-3xl font-bold text-red-900" id="presentationsPassees"><?= $statistics['presentations_Passe']; ?></p>
            </div>
        </div>

        <!-- Taux d'acceptation des suggestion -->
        <div class="bg-purple-100 p-4 rounded-lg shadow-md mb-4">
            <p class="text-lg font-semibold text-purple-800">Taux d'acceptation :</p>
            <p class="text-3xl font-bold text-purple-900" id="tauxAcceptation"><?= $statistics['taux_acceptation']; ?>%</p>
        </div>

        <!-- Classement des étudiants selon le nombre des presentation dans le calendar -->
        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">🏆 Classement des étudiants</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">#</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Prénom</th>
                        <th class="border border-gray-300 px-4 py-2">Présentations</th>
                    </tr>
                </thead>
                <tbody id="classementTable">
                    <?php $count = 1 ;foreach ($statistics['classement'] as $classement) : ?>
                        <tr class="bg-gray-200">
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $count++; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $classement['nom']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $classement['prenom']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $classement['total_presentations']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>




<?php require_once(__DIR__ . '/../partials/footer.php'); ?>