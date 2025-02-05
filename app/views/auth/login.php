
<?php require_once(__DIR__ . '/../partials/header.php'); ?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-blue-200 min-h-[550px] flex justify-center items-center">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connect</h2>
        <form action="/login" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Password : </label>
                <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button name="login" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Log in</button>
        </form>
        <p class="text-center text-gray-600 mt-4">Don't have an account? <a href="/register" class="text-blue-600 hover:underline">Sign up</a></p>
    </div>
</main>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?>
