<nav
    class="absolute top-0 left-0 right-0 z-30 flex flex-wrap items-center px-4 py-2 m-6 mb-0 shadow-sm rounded-xl bg-white/80 backdrop-blur-2xl backdrop-saturate-200 lg:flex-nowrap lg:justify-start">
    <div class="flex items-center justify-between w-full p-0 px-6 mx-auto flex-wrap-inherit">
        <a href="/"
            class="flex items-center py-1.75 text-sm mr-4 ml-4 whitespace-nowrap font-bold text-slate-700 lg:ml-0">
            <!-- Logo -->
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-7 w-7 mr-2 object-contain">
            <!-- Link text -->
            Car Sales
        </a>
        <button navbar-trigger
            class="px-3 py-1 ml-2 leading-none transition-all ease-in-out bg-transparent border border-transparent border-solid rounded-lg shadow-none cursor-pointer text-lg lg:hidden"
            type="button" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="inline-block mt-2 align-middle bg-center bg-no-repeat bg-cover w-6 h-6 bg-none">
                <span bar1
                    class="w-5.5 rounded-xs relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
                <span bar2
                    class="w-5.5 rounded-xs mt-1.75 relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
                <span bar3
                    class="w-5.5 rounded-xs mt-1.75 relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
            </span>
        </button>
        <div navbar-menu
            class="items-end flex transition-all duration-500 lg-max:overflow-hidden ease lg-max:max-h-0 basis-full lg:flex lg:basis-auto">
            <ul class="flex flex-col pl-0 mx-auto mb-0 list-none lg:flex-row xl:ml-auto "> 
                <li>
                    <a href="https://wa.me/085271744687?text=I'm%20interested%20in%20your%20product" target="_blank"
                        class="inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer hover:-translate-y-px hover:shadow-xs active:opacity-85 text-xs tracking-tight-rem">
                        <i class="fa-brands fa-whatsapp mr-2"></i>
                        Contact
                        Whatsapp</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
