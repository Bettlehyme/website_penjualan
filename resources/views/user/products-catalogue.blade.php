@extends('layouts.user')

@section('title', 'Chery Pekanbaru - Model')
@section('meta_title', 'Daftar Mobil Chery Pekanbaru | Harga & Spesifikasi Terbaru')
@section('meta_description', 'Lihat daftar mobil Chery terbaru di Pekanbaru: Omoda 5, Tiggo 7 Pro, Tiggo 8 Pro, dan lainnya. Dapatkan penawaran harga terbaik, cicilan ringan, dan layanan aftersales resmi dari Chery Pekanbaru.')
@section('meta_image', asset('assets/img/chery-logo.jpg'))
@section('meta_type', 'website')


@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <!-- Search bar -->
            <form method="GET" action="{{ route('products-catalogue') }}" class="mb-6">
                <div class="flex items-center max-w-md mx-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search cars..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <button type="submit"
                        class="px-4 py-2 bg-purple-500 text-white rounded-r-xl hover:bg-purple-600 transition">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Product grid -->
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    @forelse ($products as $p)
                        <div
                            class="bg-white rounded-md shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                            <div class="relative group">
                                <div class="absolute w-full bottom-0 left-0">
                                    <div
                                        class="flex justify-center 
         bg-gradient-to-t from-purple-500/80 via-purple-500/50 to-purple-400/0
         w-full h-fit px-2 md:px-3 lg:px-3 py-2 md:py-3 lg:py-3  
         transition-colors">
                                        <span
                                            class=" font-semibold text-md sm:text-xs md:text-md lg:text-2xl text-white uppercase">
                                            {{ $p->title }}</span>
                                    </div>
                                </div>
                               
                                <img src="{{ asset('storage/' . optional($p->galleryImages->first())->path ?? 'assets/img/default-product.png') }}"
                                alt="{{$p->title}}"
                                    class="w-full aspect-square lg:aspect-square  object-cover">

                                <!-- Hover overlay -->
                                <a href="{{ route('product-page', $p->title) }}"
                                    class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            No products found.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $products->links('pagination::tailwind') }}
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

                // Position slides
                function updateSlides() {
                    slides.forEach((slide, i) => {
                        slide.style.transform = `translateX(${(i - currentIndex) * 100}%)`;
                    });
                }

                // Next & Prev functions
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

                // Swipe support
                let startX = 0;
                let endX = 0;

                slider.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                });

                slider.addEventListener('touchmove', (e) => {
                    endX = e.touches[0].clientX;
                });

                slider.addEventListener('touchend', () => {
                    const diff = startX - endX;
                    if (diff > 50) nextSlide(); // swipe left
                    if (diff < -50) prevSlide(); // swipe right
                });

                // Auto slide every 5 seconds (5000ms)
                const intervalTime = 4000;
                let autoSlide = setInterval(nextSlide, intervalTime);

                // Optional: Pause auto-slide when hovering
                slider.addEventListener('mouseenter', () => clearInterval(autoSlide));
                slider.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(nextSlide, intervalTime);
                });

                // Initialize positions
                updateSlides();
            });
        </script>
    </div>

@endsection
