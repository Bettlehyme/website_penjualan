@extends('layouts.user')

@section('title', 'Home')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <!-- Search bar -->
            <form method="GET" action="{{ route('products-catalogue') }}" class="mb-6">
                <div class="flex items-center max-w-md mx-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search cars..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-r-xl hover:bg-blue-600 transition">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Product grid -->
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    @forelse ($products as $p)
                        <div
                            class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden flex flex-col transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                            <div class="relative group">
                                <div class="absolute top-0 bottom-0 right-0 flex items-end ">
                                    <div
                                        class="flex justify-between bg-blue-500 text-white w-fit h-fit text-sm font-semibold  py-3 px-3 rounded-l-xl hover:bg-blue-700 transition-colors">
                                        <span class="text-lg"> {{ rupiah($p->price) }}</span>
                                    </div>
                                </div>
                                <img src="{{ asset('storage/' . $p->images[0]->path) }}" alt="{{ $p->title }}"
                                    class="w-full aspect-square object-cover">

                                <!-- Hover overlay -->
                                <a href="{{ route('product-page', encrypt($p->product_id)) }}"
                                    class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    View Details
                                </a>
                            </div>

                            <div class="relative p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800">{{ $p->title }}</h4>
                                    <p class="text-md text-gray-500">{{ Str::limit($p->description, 50) }}</p>
                                </div>
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
