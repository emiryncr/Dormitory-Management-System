<nav class="bg-neutral-700/25 sticky w-full z-20 top-0 start-0 border-b border-gray-600 backdrop-blur-md">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto md:p-0 px-3">
            <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="../../img/lightLogo.png" class="h-20" alt="DELUXE DORMS">
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center hover:scale-105 duration-200 montserrat">Logout</button>
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 hover:bg-gray-700 focus:ring-gray-600 border border-neutral-500" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        menu
                    </span>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-1 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 mb-2 md:mb-0">
                    <?php foreach ($links as $name => $url): ?>
                        <li>
                            <a href="<?= $url ?>" class="block py-1 px-3 hover:bg-gray-100/25 md:hover:bg-transparent text-white md:p-0 rounded hover:scale-110 hover:md:scale-115 duration-200 montserrat"><?= $name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>