<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Document</title>

    <!-- pour le calendrier **************************************************************** -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <!-- pour le calendrier **************************************************************** -->


</head>

<body>

    <header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
        <div class='flex flex-wrap items-center justify-between gap-5 w-full'>
            <a href="/home" class="max-sm:hidden">
                <h1 class="text-3xl"><span class="text-indigo-600 font-bold">V</span>eille<span class="text-indigo-600 font-bold">H</span>ub</h1>
            </a>
            <a href="/home" class="hidden max-sm:block">
                <h1 class="text-3xl"><span class="text-indigo-600 font-bold">V</span><span class="text-indigo-600 font-bold">H</span></h1>
            </a>

            <div id="collapseMenu"
                class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
                <button id="toggleClose" class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-black" viewBox="0 0 320.591 320.591">
                        <path
                            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                            data-original="#000000"></path>
                        <path
                            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                            data-original="#000000"></path>
                    </svg>
                </button>

                <ul
                    class='lg:flex gap-x-5 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50'>
                    <li class='mb-6 hidden max-lg:block'>
                        <a href="/home">
                            <h1 class="text-3xl"><span class="text-indigo-600 font-bold">V</span>eille<span class="text-indigo-600 font-bold">H</span>ub</h1>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_loged_in_role']) && $_SESSION['user_loged_in_role'] == "Enseignant") : ?>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/home'
                                class='hover:text-[#4CAF50] text-[#4CAF50] block font-semibold text-[15px]'>Home</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/teacher/calendar'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>calendar</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/teacher/suggestions'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>suggestions</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/teacher/subjects'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>subjects</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/teacher/students'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>Students</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/teacher/statistiques'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>Statistiques</a>
                        </li>
                    <?php elseif (isset($_SESSION['user_loged_in_role']) && $_SESSION['user_loged_in_role'] == "Etudiant") : ?>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/home'
                                class='hover:text-[#4CAF50] text-[#4CAF50] block font-semibold text-[15px]'>Home</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/student/calendar'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>calendar</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/student/my_suggestions'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>My suggestions</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/student/subjects'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>subjects</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/student/notifications'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>Notifications</a>
                        </li>
                        <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                            <a href='/student/statistiques'
                                class='hover:text-[#4CAF50] text-[#2196F3] block font-semibold text-[15px]'>Statistiques</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class='flex max-lg:ml-auto space-x-4'>
                <?php if (!isset($_SESSION["user_loged_in_id"])) : ?>
                    <a href="/login">
                        <button
                            class='px-4 py-2 text-sm rounded-full font-bold text-[#2196F3] border-2 bg-transparent hover:bg-gray-50 transition-all ease-in-out duration-300'>
                            Login
                        </button>
                    </a>
                    <a href="/register">
                        <button
                            class='px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-[#4CAF50] bg-[#4CAF50] transition-all ease-in-out duration-300 hover:bg-transparent hover:text-[#4CAF50]'>
                            Sign up
                        </button>
                    </a>
                <?php else: ?>
                    <form action="/logout" method="POST">
                        <button type="submit"
                            class='px-4 py-2 text-sm rounded-full font-bold text-[#2196F3] border-2 bg-transparent hover:bg-gray-50 transition-all ease-in-out duration-300'>
                            Logout
                        </button>
                    </form>
                <?php endif; ?>


                <button id="toggleOpen" class='lg:hidden'>
                    <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>