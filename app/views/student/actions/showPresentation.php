<?php require_once(__DIR__ . '/../../partials/header.php'); ?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[600px] flex justify-center items-center">

    <!-- ********************************************************************************************************************************************************************** -->


    <div class="w-full max-w-lg bg-yellow-50 shadow-lg rounded-lg p-8 relative">
        <div class="flex flex-col justify-center">
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Title : <span class="text-base text-black font-normal"><?= $presentation->titre; ?></span></h3>
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Description : <span class="text-base text-black font-normal"><?= $presentation->description; ?></span></h3>
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Status : <span class="text-base text-black font-normal"><?= $presentation->status; ?></span></h3>
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Teacher : <span class="text-base text-black font-normal"><?= $presentation->id_enseignant; ?></span></h3>
            <h3 class="text-indigo-600 text-xl font-bold flex-1">Link : <span class="text-base text-black font-normal"><a href="<?= $presentation->lien_presentation; ?>">Click here to show Presentation</a></span></h3>
        </div>

        <div>

        </div>
    </div>




    <!-- ********************************************************************************************************************************************************************** -->

</main>

<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>