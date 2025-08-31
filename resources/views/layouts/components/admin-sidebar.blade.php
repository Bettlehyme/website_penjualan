<aside
    class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0"
    aria-expanded="false">
    <div class="h-19">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
            sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700"
            href="#CarCompany" target="_blank">
            <img src="./assets/img/logo.png"
                class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8"
                alt="main_logo" />
            <img src="./assets/img/logo.png"
                class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8"
                alt="main_logo" />
            <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Car Sales</span>
        </a>
    </div>

    <hr
        class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
            <li class="mt-0.5 w-full">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors
        {{ request()->routeIs('dashboard') ? 'bg-blue-500/13 text-slate-700 dark:text-white' : 'text-slate-700 dark:text-white dark:opacity-80' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 fa-solid fa-grip"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors
        {{ request()->routeIs('banners.index') ? 'bg-blue-500/13 text-slate-700 dark:text-white' : 'text-slate-700 dark:text-white dark:opacity-80' }}"
                    href="{{ route('banners.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 fa-solid fa-images"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Banners</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors
        {{ request()->routeIs('product.index') ? 'bg-blue-500/13 text-slate-700 dark:text-white' : 'text-slate-700 dark:text-white dark:opacity-80' }}"
                    href="{{ route('product.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 fa-solid fa-car-side"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Product</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors
        {{ request()->routeIs('user.index') ? 'bg-blue-500/13 text-slate-700 dark:text-white' : 'text-slate-700 dark:text-white dark:opacity-80' }}"
                    href="{{ route('user.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 fa-solid fa-users"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">User</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
