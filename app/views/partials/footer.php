<footer class="bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 py-10 px-10 font-sans tracking-wide">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex flex-wrap items-center md:justify-between max-md:flex-col gap-6">
            <div>
                <a href='javascript:void(0)'><img src="https://readymadeui.com/readymadeui-light.svg" alt="logo" class='w-36 ' /></a>
            </div>

            <ul class="flex items-center justify-center flex-wrap gap-y-2 md:justify-end space-x-6">
                <li><a href="javascript:void(0)" class="text-gray-300 hover:underline text-base">Home</a></li>
                <li><a href="javascript:void(0)" class="text-gray-300 hover:underline text-base">About</a></li>
                <li><a href="javascript:void(0)" class="text-gray-300 hover:underline text-base">Services</a></li>
                <li><a href="javascript:void(0)" class="text-gray-300 hover:underline text-base">Contact</a></li>
            </ul>
        </div>

        <hr class="my-6 border-gray-500" />

        <p class='text-center text-gray-300 text-base'>© ReadymadeUI. All rights reserved.</p>
    </div>
</footer>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleOpen = document.getElementById("toggleOpen");
        const toggleClose = document.getElementById("toggleClose");
        const collapseMenu = document.getElementById("collapseMenu");

        toggleOpen.addEventListener("click", function() {
            collapseMenu.classList.remove("max-lg:hidden");
            collapseMenu.classList.add("max-lg:block");
        });

        toggleClose.addEventListener("click", function() {
            collapseMenu.classList.remove("max-lg:block");
            collapseMenu.classList.add("max-lg:hidden");
        });

        document.addEventListener("click", function(event) {
            if (!collapseMenu.contains(event.target) && !toggleOpen.contains(event.target)) {
                collapseMenu.classList.remove("max-lg:block");
                collapseMenu.classList.add("max-lg:hidden");
            }
        });
    });
</script>


</body>


</html>