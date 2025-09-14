<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start"
    navbar-main navbar-scroll="false">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <!-- breadcrumb -->
            <ol
                class="flex flex-wrap items-center gap-1 pt-1 sm:pt-2 md:pt-3 lg:pt-4 mr-4 sm:mr-8 md:mr-12 bg-transparent rounded-lg">
                <li class="text-xs sm:text-sm leading-normal">
                    <a class="text-white opacity-50" href="{{ route('dashboard') }}">Pages</a>
                </li>
                <li
                    class="text-xs sm:text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']">
                    @if (Route::is('dashboard'))
                        Dashboard
                    @elseif (Route::is('banners.index'))
                        Banners
                    @elseif (Route::is('product.index'))
                        Product
                    @elseif (Route::is('article.index'))
                        Article
                    @elseif (Route::is('gallery.index'))
                        Gallery
                    @elseif (Route::is('site-settings.index'))
                        Site Settings
                    @elseif (Route::is('user.index'))
                        User
                    @endif
                </li>
            </ol>

            <!-- page title -->
            <h6 class="mb-0 font-bold text-white capitalize text-base sm:text-lg md:text-xl">
                @if (Route::is('dashboard'))
                    Dashboard
                @elseif (Route::is('banners.index'))
                    Banners
                @elseif (Route::is('product.index'))
                    Product
                @elseif (Route::is('article.index'))
                    Article
                @elseif (Route::is('gallery.index'))
                    Gallery
                @elseif (Route::is('site-settings.index'))
                    Site Settings
                @elseif (Route::is('user.index'))
                    User
                @endif
            </h6>
        </nav>


        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full md:ml-auto">
                {{-- If user is not logged in --}}
                @guest
                    <li class="flex items-center">
                        <a href="{{ route('login') }}"
                            class="block px-0 py-2 text-sm font-semibold text-white transition-all ease-nav-brand">
                            <i class="fa fa-user sm:mr-1"></i>
                            <span class="hidden sm:inline">Sign In</span>
                        </a>
                    </li>
                @endguest

                {{-- If user IS logged in --}}
                @auth
                    <li class="flex items-center ">
                        <span
                            class="block px-5 py-1 text-sm font-semibold text-purple-500 bg-white rounded-xl transition-all ease-nav-brand">
                            <i class="fa fa-user sm:mr-1"></i>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                        </span>
                    </li>
                    <li class="flex items-center ml-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block px-3 py-2 text-sm font-semibold text-white hover:text-red-500 transition-all ease-nav-brand">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    </li>
                @endauth

                {{-- Mobile toggle --}}
                <li class="flex items-center pl-4 xl:hidden ">
                    <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand "
                        sidenav-trigger>
                        <div class="w-4.5 overflow-hidden">
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                            <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                        </div>
                    </a>
                </li>

                {{-- Settings --}}
                {{-- <li class="flex items-center px-4">
                    <a href="javascript:;" class="p-0 text-sm text-white transition-all ease-nav-brand">
                        <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                    </a>
                </li> --}}

                {{-- Notifications --}}
                <li class="relative flex items-center pr-2">
                    {{-- keep your dropdown notification code here --}}
                </li>
            </ul>

        </div>
    </div>
</nav>
