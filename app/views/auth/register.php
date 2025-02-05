<?php require_once(__DIR__ . '/../partials/header.php'); ?>


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-screen flex justify-center items-center">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>
        <form action="/register" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nom : </label>
                <input type="text" name="nom" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Prénom : </label>
                <input type="text" name="prenom" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Rôle : </label>
                <select name="role" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="" class="text-gray-500 bg-gray-300">Choisir votre Rôle</option>
                    <option value="Enseignant">Enseignant</option>
                    <option value="Etudiant">Etudiant</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Mot de passe : </label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Mot de passe (Confirmation) : </label>
                <input type="password" name="password2" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <button name="signup" class="w-full bg-indigo-600 text-white p-2 rounded-lg hover:bg-indigo-700">Sign Up</button>
        </form>
        <p class="text-center text-gray-600 mt-4">Already have an account? <a href="/login" class="text-indigo-600 hover:underline">Log in</a></p>
    </div>

</main>
<?php require_once(__DIR__ . '/../partials/footer.php'); ?>