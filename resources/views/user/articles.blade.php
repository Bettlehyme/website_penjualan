@extends('layouts.user')

@section('title', 'Chery Pekanbaru - Articles')
@section('meta_title', 'Berita & Tips Mobil Chery Pekanbaru | Artikel Otomotif Terbaru')
@section('meta_description', 'Baca berita, tips, dan update terbaru seputar mobil Chery di Pekanbaru. Dapatkan informasi tentang promo dealer, perawatan mobil, dan teknologi terbaru dari Chery Indonesia.')
@section('meta_image', asset('assets/img/chery-logo.jpg'))
@section('meta_type', 'website')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <!-- Search bar -->
            <form method="GET" action="{{ route('articles-list') }}" class="mb-6">
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
                    @forelse ($articles as $a)
                       <a href="{{ route('article-page', $a->title) }}" aria-label="{{$a->title}}">

                            <div
                                class="bg-white rounded-md shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                                <div class="relative group">
                                    <div class="absolute w-full bottom-0 left-0">
                                    </div>
                                    <img src="{{ asset('storage/' . $a->image) }}" alt="{{ $a->title }}"
                                        class="w-full aspect-video lg:aspect-video  object-cover">

                                </div>
                                <div class="p-3">
                                    <span class="font-bold text-lg">{{ $a->title }}</span>
                                    <p class="font-normal text-sm line-clamp-2 lg:line-clamp-3">
                                        {{ $a->description }}
                                    </p>
                                    <span class="text-xs">
                                        <i class="fa-solid fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($a->created_at)->diffForHumans() }}</span>
                                </div>

                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            No Article found.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $articles->links('pagination::tailwind') }}
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
