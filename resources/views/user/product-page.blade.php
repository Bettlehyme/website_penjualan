@extends('layouts.user')

@section('title', 'Home')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <div class="flex flex-wrap -mx-3">
                <div
                    class="w-full mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-lg flex flex-col md:flex-col lg:flex-row  gap-6">
                    <!-- Left: Product Image Slider -->
                    <div class="relative w-full md:w-1/2 h-full">
                        <!-- Images Wrapper -->
                        <div class="overflow-hidden rounded-lg relative " id="slider" slider>
                            @foreach ($product->images as $index => $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->title }}" slide
                                    class="w-full aspect-square object-cover transition-transform duration-500 ease-in-out {{ $index === 0 ? '' : 'hidden' }}">
                            @endforeach
                            <div class="absolute bottom-0 w-full right-0 flex z-20">
                                <div
                                    class="bg-blue-500 text-white sm:text-base w-full text-center font-semibold py-2 px-3 sm:px-4  hover:bg-blue-700 transition-colors">
                                    <span class="text-4xl sm:text-4xl md:text-4xl lg:text-3xl ">{{ rupiah($product->price) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price Badge -->


                        <!-- Slider Controls -->
                        <button btn-prev
                            class="absolute top-1/2 left-2 sm:left-3 -translate-y-1/2 bg-black/50 text-white p-2 sm:p-3 rounded-full hover:bg-black/70 z-20">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button btn-next
                            class="absolute top-1/2 right-2 sm:right-3 -translate-y-1/2 bg-black/50 text-white p-2 sm:p-3 rounded-full hover:bg-black/70 z-20">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Right: Product Details -->
                    <div class="grid grid-cols-1 w-full sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Title -->
                        <div class="bg-white rounded-xl shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3">
                            <h1 class="text-xxl font-bold text-gray-900">{{ $product->title }}</h1>
                        </div>

                        <!-- Brand -->
                        <div class="bg-white rounded-xl shadow-md p-4">
                            <label>Brand</label>
                            <p class="text-gray-700 text-xl font-bold mt-1">{{ $product->brand }}</p>
                        </div>

                        <!-- Model -->
                        <div class="bg-white rounded-xl shadow-md p-4">
                            <label>Model</label>
                            <p class="text-gray-700 font-bold text-xl mt-1">{{ $product->model }}</p>
                        </div>

                        <!-- Year -->
                        <div class="bg-white rounded-xl shadow-md p-4">
                            <label>Year</label>
                            <p class="text-gray-700 font-bold text-xl mt-1">{{ $product->year }}</p>
                        </div>

                        <!-- Description -->
                        <div class="bg-white rounded-xl shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3">
                            <label>Description</label>
                            <p class="text-gray-700 text-xl font-bold mt-1">{{ $product->description }}</p>
                        </div>

                        <!-- Actions -->
                        <div
                            class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3">
                            <button onclick="shareProduct()"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center flex items-center justify-center">
                                <i class="fa-solid fa-share-nodes mr-2"></i>
                                Share
                            </button>
                            <a href="https://wa.me/085271744687?text=I'm%20interested%20in%20your%20product"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                                <i class="fa-brands fa-whatsapp mr-2"></i>
                                Contact Us
                            </a>
                        </div>
                    </div>

                </div>


                <div class="w-full max-w-full grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4 mt-6">
                    @foreach ($products as $p)
                        <div
                            class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                            <div class="relative group">
                                <div class="absolute top-0 bottom-0 right-0 flex items-end  ">
                                    <div
                                        class="flex justify-between bg-blue-500 text-white w-fit h-fit text-end font-semibold  py-3 px-3 rounded-l-xl hover:bg-blue-700 transition-colors ">
                                        <span class="text-sm sm:text-sm md:text-md lg:text-lg "> {{ rupiah($p->price) }}</span>
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

                            <div class="relative p-4 flex-1 flex flex-col justify-between ">
                                <div>
                                    <h4 class="font-semibold text-gray-800 m-0 p-0 text-sm sm:text-sm md:text-md lg:text-lg">{{ $p->title }}</h4>
                                    <p class=" text-gray-500 mt-0 text-xs sm:text-sm md:text-md lg:text-lg">{{ Str::limit($p->description, 50) }}</p>
                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slider = document.querySelector('[slider]');
                const slides = slider.querySelectorAll('[slide]');
                const nextBtn = document.querySelector('[btn-next]');
                const prevBtn = document.querySelector('[btn-prev]');
                let currentIndex = 0;

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.toggle('hidden', i !== index);
                    });
                }

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % slides.length;
                    showSlide(currentIndex);
                }

                function prevSlide() {
                    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                    showSlide(currentIndex);
                }

                nextBtn.addEventListener('click', nextSlide);
                prevBtn.addEventListener('click', prevSlide);

                // --- Touch support (swipe left/right) ---
                let startX = 0;
                let endX = 0;

                slider.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                });

                slider.addEventListener('touchend', (e) => {
                    endX = e.changedTouches[0].clientX;
                    let diffX = startX - endX;

                    if (Math.abs(diffX) > 50) { // swipe threshold
                        if (diffX > 0) {
                            nextSlide(); // swipe left → next
                        } else {
                            prevSlide(); // swipe right → prev
                        }
                    }
                });

                // Initialize
                showSlide(currentIndex);

                function shareProduct() {
                    if (navigator.share) {
                        navigator.share({
                            title: "{{ $product->title }}",
                            text: "Check out this product: {{ $product->title }}",
                            url: window.location.href
                        });
                    } else {
                        alert("Sharing not supported on this browser. Copy the link manually.");
                    }
                }
            });
        </script>

    </div>

@endsection
