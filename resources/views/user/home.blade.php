@extends('layouts.user')

@section('title', 'Home')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full aspect-[4/3] md:aspect-[8/3] lg:aspect-[8/3]  max-w-full top-1 lg:w-12/12 lg:flex-none">
                    <div
                        class="relative w-full h-full overflow-hidden rounded-2xl bg-gray-100 flex items-center justify-center">

                        @if ($activeBanners->isNotEmpty())
                            <div slider class="relative w-full h-full overflow-hidden rounded-2xl">
                                @foreach ($activeBanners as $banner)
                                    <div slide class="absolute w-full h-full transition-all duration-500">
                                        <img class="object-cover h-full w-full" src="{{ asset('storage/' . $banner->image) }}"
                                            alt="banner image" />

                                        <div
                                            class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                                            @if ($banner->icon)
                                                <div
                                                    class="inline-block w-8 h-8 mb-4 text-center text-black bg-white rounded-lg">
                                                    <i class="{{ $banner->icon }} text-xxs relative text-slate-700"></i>
                                                </div>
                                            @endif
                                            <h5 class="mb-1 text-white">{{ $banner->title }}</h5>
                                            <p class="dark:opacity-80">{{ $banner->description }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Control buttons -->
                                <button btn-next
                                    class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 fa-solid fa-chevron-right active:scale-110 top-6 right-4"></button>
                                <button btn-prev
                                    class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 fa-solid fa-chevron-left active:scale-110 top-6 right-16"></button>
                            </div>
                        @else
                            <!-- Fallback if no active banners -->
                            <div class="w-full h-full flex items-center justify-center text-center p-6">
                                <p class="text-gray-500 text-lg font-semibold">Upload banner first</p>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="w-full md:h-[80vh] lg:h-[80vh] flex items-center mt-10">
                    <div class="container mx-auto px-6 lg:px-16 grid grid-cols-1 lg:grid-cols-2 gap-8 h-full">
                        <!-- Left Side (Image) -->
                        <div class="flex items-center justify-center h-full overflow-hidden">
                            <img src="{{ asset('assets/img/home-image-1.jpeg') }}" alt="Luxury Car"
                                class="w-full h-full object-cover aspect-[16/9] md:aspect-[8/3] lg:aspect-[8/3] rounded-2xl shadow-lg">
                        </div>

                        <!-- Right Side (Text) -->
                        <div class="flex flex-col justify-center items-center  md:items-start lg:items-start h-full">
                            <h2 class=" font-bold text-gray-800 mb-4 text-xl md:text-3xl lg:text-4xl">Find Your Dream Car
                            </h2>
                            <p class="text-lg text-gray-600 mb-6 text-center">
                                Explore our wide range of cars that suit every lifestyle and budget.
                                From luxury rides to reliable daily drivers, we’ve got it all.
                            </p>
                            <a href="https://wa.me/085271744687?text=I'm%20interested%20in%20your%20product"
                                class="px-6 py-3 bg-blue-500 text-white rounded-xl shadow-md hover:bg-blue-700 transition w-full text-center md:w-auto lg:w-auto">
                                Contact Us on WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-b"></div>
                <h3 class="w-full pt-8 text-center ">Latest Cars</h3>
                <div class="w-full max-w-full grid grid-cols-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    @foreach ($products as $p)
                        <div
                            class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                            <div class="relative group">
                                <div class="absolute top-0 bottom-0 right-0 flex items-end  ">
                                    <div
                                        class="flex justify-between bg-blue-500 text-white w-fit h-fit text-end font-semibold  py-2 px-2 md:py-3 md:px-3 lg:py-3 lg:px-3 rounded-tl-xl hover:bg-blue-700 transition-colors ">
                                        <span class="text-xs sm:text-xs md:text-md lg:text-lg ">
                                            {{ rupiah($p->price) }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('storage/' . $p->images[0]->path) }}" alt="{{ $p->title }}"
                                    class="w-full aspect-video lg:aspect-square  object-cover">

                                <!-- Hover overlay -->
                                <a href="{{ route('product-page', encrypt($p->product_id)) }}"
                                    class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    View Details
                                </a>
                            </div>

                            <div class="relative px-3 pt-3 flex-1 flex flex-col justify-between ">
                                <div>
                                    <h4
                                        class="font-semibold text-gray-800 m-0 p-0 text-sm sm:text-sm md:text-md lg:text-lg">
                                        {{ $p->title }}</h4>
                                    <p
                                        class="text-gray-500 mt-0 text-xs sm:text-sm md:text-md lg:text-lg 
   overflow-hidden text-ellipsis line-clamp-2 sm:line-clamp-3 md:line-clamp-4">
                                        {{ $p->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div
                        class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        <div class="relative group">
                            <!-- Blurry placeholder image -->
                            <div class="w-full aspect-video lg:aspect-square bg-gray-200 flex items-center justify-center">
                                <img src="{{ asset('assets/img/car-placeholder.jpg') }}" alt="More cars"
                                    class="w-full h-full object-cover blur-md opacity-70">
                                <span class="absolute text-xl font-bold text-white drop-shadow-lg">More Cars</span>

                            </div>
                            <!-- Hover overlay -->
                            <a href="{{ route('products-catalogue') }}"
                                class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                More Cars
                            </a>
                        </div>

                        <div class="relative p-4 flex-1 flex flex-col justify-center items-center">
                            <h4 class="text-md font-semibold text-gray-600">See More</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slider = document.querySelector('[slider]');
                const slides = slider.querySelectorAll('[slide]');
                const nextBtn = slider.querySelector('[btn-next]');
                const prevBtn = slider.querySelector('[btn-prev]');
                let currentIndex = 0;
                const total = slides.length;
                let startX = 0,
                    currentX = 0,
                    isDragging = false;

                // --- Position slides ---
                function updateSlides(withTransition = true) {
                    slides.forEach((slide, i) => {
                        slide.style.transition = withTransition ? "transform 0.3s ease" : "none";
                        slide.style.transform = `translateX(${(i - currentIndex) * 100}%)`;
                    });
                }

                // --- Navigation ---
                function nextSlide() {
                    currentIndex = (currentIndex + 1) % total;
                    updateSlides();
                }

                function prevSlide() {
                    currentIndex = (currentIndex - 1 + total) % total;
                    updateSlides();
                }

                nextBtn.addEventListener('click', nextSlide);
                prevBtn.addEventListener('click', prevSlide);

                // --- Touch & Mouse drag support ---
                function dragStart(x) {
                    startX = x;
                    currentX = x;
                    isDragging = true;
                    updateSlides(false); // disable transition during drag
                }

                function dragMove(x) {
                    if (!isDragging) return;
                    currentX = x;
                    let diffX = currentX - startX;

                    slides.forEach((slide, i) => {
                        let offset = (i - currentIndex) * 100 + (diffX / slider.offsetWidth) * 100;
                        slide.style.transform = `translateX(${offset}%)`;
                    });
                }

                function dragEnd() {
                    if (!isDragging) return;
                    isDragging = false;
                    let diffX = currentX - startX;

                    if (Math.abs(diffX) > slider.offsetWidth / 4) {
                        if (diffX > 0) prevSlide();
                        else nextSlide();
                    } else {
                        updateSlides(); // snap back
                    }
                }

                // --- Touch events ---
                slider.addEventListener('touchstart', e => dragStart(e.touches[0].clientX));
                slider.addEventListener('touchmove', e => dragMove(e.touches[0].clientX));
                slider.addEventListener('touchend', dragEnd);

                // --- Mouse events ---
                slider.addEventListener('mousedown', e => dragStart(e.clientX));
                slider.addEventListener('mousemove', e => dragMove(e.clientX));
                slider.addEventListener('mouseup', dragEnd);
                slider.addEventListener('mouseleave', dragEnd);

                // --- Auto slide ---
                const intervalTime = 4000;
                let autoSlide = setInterval(nextSlide, intervalTime);

                slider.addEventListener('mouseenter', () => clearInterval(autoSlide));
                slider.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(nextSlide, intervalTime);
                });

                // --- Init ---
                updateSlides();
            });
        </script>

    </div>

@endsection
