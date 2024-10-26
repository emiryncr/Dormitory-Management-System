<div>
    <h1 class="text-white text-4xl text-center">Manage Managers</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">
        
        <div class="flex justify-center sm:flex-row flex-col gap-2">
            <button id="addBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300 min-w-max">Add Manager</button>
            <div class="relative">
                <input type="text" class="input bg-gray-200 text-gray-800 pl-4 pr-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-full" placeholder="Search Manager"/>
                <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-600 hover:text-gray-800 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>

        <div class="sampleContent mt-5 text-white grid sm:grid-cols-4 grid-cols-1 gap-4">
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
            <div class="content bg-neutral-700/75 text-center h-20">
                Content
            </div>
        </div>

    </div>

    <div id="addModal" class="hidden fixed z-10 inset-0 overflow-y-auto backdrop-blur-md">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-neutral-300 rounded-lg sm:p-6 p-4 shadow-lg sm:min-w-96 max-w-64">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="sm:text-xl text-md font-semibold">Add Manager Pop-Up</h2>
                <button id="closeModalBtn" class="text-red-700 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="" method="POST">
                <div class="sm:mt-4 mt-2">
                    <label for="mngUsername" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="mngUsername" name="mngUsername" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngFullName" class="block text-sm font-medium text-gray-700">Manager Full Name</label>
                    <input type="text" id="mngFullName" name="mngFullName" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="mngPhone" name="mngPhone" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngDorms" class="block text-sm font-medium text-gray-700">Dorms</label>
                    <input type="text" id="mngDorms" name="mngDorms" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <hr class="mt-2">
                <div class="sm:mt-4 mt-2">
                    <button type="submit" class="bg-orange-700 text-white sm:px-4 sm:py-2 px-2 py-1 rounded hover:bg-orange-500 transition duration-300 sm:text-md text-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>