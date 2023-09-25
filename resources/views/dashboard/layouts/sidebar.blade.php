<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="{{ route('dashboard') }}">
            Admin Panel
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="relative px-6 py-3">
                @if (Request::is('produk*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('produk*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="#">
                    <i class="ri-box-3-line text-lg"></i>
                    <span class="ml-4">Produk</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                @if (Request::is('page*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="{{ Request::is('page*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center justify-between w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300 focus:outline-none" @click="togglePagesMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <i class="ri-layout-3-line text-lg"></i>
                        <span class="ml-4">Pages</span>
                    </span>
                    <i class="ri-arrow-down-s-line text-base"></i>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="pages/login.html">
                                Login
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="pages/register.html">
                                Register
                            </a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
        {{-- <div class="px-6 my-6">
            <button class="flex items-center justify-start w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="ri-arrow-left-line mr-2"></i>
                Kembali
            </button>
        </div> --}}
    </div>
</aside>

<!-- Mobile sidebar -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 font-lato" href="{{ route('dashboard') }}">
            Admin Panel
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if (Request::is('dashboard*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('dashboard*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="{{ route('dashboard') }}">
                    <i class="ri-home-4-line text-lg"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="relative px-6 py-3">
                @if (Request::is('produk*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ Request::is('produk*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" href="#">
                    <i class="ri-box-3-line text-lg"></i>
                    <span class="ml-4">Produk</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                @if (Request::is('page*'))
                    <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="{{ Request::is('page*') ? 'font-semibold text-purple-600 dark:text-purple-300' : 'text-gray-500 dark:text-gray-100' }} inline-flex items-center justify-between w-full text-sm transition-colors duration-150 hover:text-purple-600 dark:hover:text-purple-300" @click="togglePagesMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <i class="ri-layout-3-line text-lg"></i>
                        <span class="ml-4">Pages</span>
                    </span>
                    <i class="ri-arrow-down-s-line text-base"></i>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="pages/login.html">
                                Login
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="pages/register.html">
                                Register
                            </a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
        {{-- <div class="px-6 my-6">
            <button class="flex items-center justify-start w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <i class="ri-arrow-left-line mr-2"></i>
                Kembali
            </button>
        </div> --}}
    </div>
</aside>
