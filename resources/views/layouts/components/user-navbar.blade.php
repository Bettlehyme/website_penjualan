<nav
    class="absolute top-0 left-0 right-0 z-30 flex flex-wrap items-center py-2 shadow-sm bg-white/80 backdrop-blur-2xl backdrop-saturate-200 lg:flex-nowrap lg:justify-start">
    <div class="container flex items-center justify-between w-full p-0 px-6 mx-auto flex-wrap-inherit">
        <a href="/"
            class="flex items-center py-1.75 w-4/12  text-sm mr-4 ml-4 whitespace-nowrap font-bold text-slate-700 lg:ml-0">
            <!-- Logo -->
            <img src="{{ setting('logo') ? asset('storage/' . setting('logo')) : 'https://via.placeholder.com/100' }}"
                alt="Logo" class="w-12/12 lg:w-6/12  object-contain">
            <!-- Link text -->
            {{-- {{ setting('site_name') }} --}}
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
            class="flex relative w-12/12 h-fit pt-1 justify-between transition-all duration-500 ease lg-max:max-h-0 basis-full flex-col lg:flex-row lg:basis-auto 
    overflow-hidden md:overflow-visible"
            role="navigation" aria-label="Main navigation">
            <ul class="flex relative flex-col w-full pl-0 mb-0 list-none lg:flex-row" role="menubar"
                aria-label="Main menu">
                <li role="none">
                    <a href="{{ route('home') }}" role="menuitem" aria-label="Go to Home page"
                        class="relative inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center align-middle 
                transition-all ease-in border-0 rounded-lg cursor-pointer 
                text-sm tracking-tight-rem uppercase 
                hover:text-purple-500 after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:h-[2px] after:w-0 after:bg-purple-500 after:transition-all after:duration-300 hover:after:w-full">
                        Home
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('price-list') }}" role="menuitem" aria-label="View car price lists"
                        class="relative inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center align-middle 
                transition-all ease-in border-0 rounded-lg cursor-pointer 
                text-sm tracking-tight-rem uppercase 
                hover:text-purple-500 after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:h-[3px] after:w-0 after:bg-purple-500 after:transition-all after:duration-300 hover:after:w-full">
                        Price Lists
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('articles-list') }}" role="menuitem" aria-label="View promotions and articles"
                        class="relative inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center align-middle 
                transition-all ease-in border-0 rounded-lg cursor-pointer 
                text-sm tracking-tight-rem uppercase 
                hover:text-purple-500 after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:h-[3px] after:w-0 after:bg-purple-500 after:transition-all after:duration-300 hover:after:w-full">
                        Promo & Artikel
                    </a>
                </li>
                <li class="relative" role="none">
                    <a href="{{ route('products-catalogue') }}" id="dropdownToggle" role="menuitem" aria-haspopup="true"
                        aria-expanded="false" aria-controls="model-submenu" aria-label="View car models"
                        class="relative inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center align-middle 
                transition-all ease-in border-0 rounded-lg cursor-pointer 
                text-sm tracking-tight-rem uppercase 
                hover:text-purple-500 after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:h-[3px] after:w-0 after:bg-purple-500 after:transition-all after:duration-300 hover:after:w-full">
                        Model
                    </a>
                </li>
                <li role="none">
                    <a href="{{ route('gallery-list') }}" role="menuitem" aria-label="View car gallery"
                        class="relative inline-block px-8 py-2 mb-0 mr-1 font-bold leading-normal text-center align-middle 
                transition-all ease-in border-0 rounded-lg cursor-pointer 
                text-sm tracking-tight-rem uppercase 
                hover:text-purple-500 after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:h-[3px] after:w-0 after:bg-purple-500 after:transition-all after:duration-300 hover:after:w-full">
                        Galeri
                    </a>
                </li>
            </ul>

            <ul class="flex flex-col w-80 pl-0 mb-0 sm:flex-row lg:flex-row" role="menubar" aria-label="Contact menu">
                <li role="none">
                    <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Hallo,%20saya%20ingin%20bertanya"
                        target="_blank" role="menuitem" aria-label="Chat via WhatsApp" aria-describedby="whatsapp-desc"
                        class="inline-block px-8 py-2 mb-0 mr-1 font-semibold leading-normal text-center text-white align-middle transition-all ease-in bg-purple-500 border-0 rounded-lg shadow-md cursor-pointer hover:-translate-y-px hover:shadow-xs active:opacity-85 text-sm tracking-tight-rem">
                        <i class="fa-brands fa-whatsapp mr-2" aria-hidden="true"></i>
                        Contact Whatsapp
                    </a>
                    <span id="whatsapp-desc" class="sr-only">Opens WhatsApp chat in a new window</span>
                </li>
            </ul>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentPath = window.location.pathname;
            const links = document.querySelectorAll("ul li a"); // adjust 'nav' if needed
            const toggle = document.getElementById("dropdownToggle");
            const menu = document.getElementById("dropdownMenu");
            const parent = toggle.parentElement;
            console.log(currentPath);
            links.forEach(link => {
                // Match by pathname
                if (link.getAttribute("href") === currentPath) {
                    link.classList.add("active-link");


                }
                console.log(link.getAttribute("href"));
            });

            parent.addEventListener("mouseenter", () => {
                menu.classList.remove("opacity-0", "translate-y-2", "invisible");
                menu.classList.add("opacity-100", "translate-y-0", "visible");
            });

            parent.addEventListener("mouseleave", () => {
                menu.classList.remove("opacity-100", "translate-y-0", "visible");
                menu.classList.add("opacity-0", "translate-y-2", "invisible");
            });
        });
    </script>
</nav>
