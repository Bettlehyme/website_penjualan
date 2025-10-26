@extends('layouts.user')

@section('title', 'Chery Pekanbaru - Price List')
@section('meta_title', 'Harga Mobil Chery Pekanbaru 2025 | Harga Omoda & Tiggo Terbaru')
@section('meta_description', 'Cek harga mobil Chery di Pekanbaru tahun 2025. Dapatkan penawaran spesial untuk Chery Omoda 5, Tiggo 7 Pro, dan Tiggo 8 Pro. Konsultasi gratis untuk pembelian dan test drive di dealer resmi Chery Pekanbaru.')
@section('meta_image', asset('assets/img/chery-logo.jpg'))
@section('meta_type', 'website')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
       
            <!-- Product grid -->
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full">
                    <img src="{{ setting('price_list') ? asset('storage/' . setting('price_list')) : 'https://via.placeholder.com/100' }}"
                alt="Logo" class="w-full mr-2 object-contain">
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
