@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <!-- cards row 2 -->
        <div class="w-full aspect-[10/3] max-w-full px-3 lg:w-12/12 lg:flex-none">
            <div class="relative w-full h-full overflow-hidden rounded-2xl bg-gray-100 flex items-center justify-center">

                @if ($activeBanners->isNotEmpty())
                    <div slider class="relative w-full h-full overflow-hidden rounded-2xl">
                        @foreach ($activeBanners as $banner)
                            <div slide class="absolute w-full h-full transition-all duration-500">
                                <img class="object-cover h-full w-full" src="{{ asset('storage/' . $banner->image) }}"
                                    alt="banner image" />

                                <div
                                    class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                                    @if ($banner->icon)
                                        <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white rounded-lg">
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

        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-12/12 lg:flex-none">
                @if ($banners->isEmpty())
                    <div class="flex justify-center items-center h-32 text-gray-500 border border-dashed rounded-lg">
                        Upload banner first
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach ($banners as $banner)
                            <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img src="{{ asset('storage/' . $banner->image) }}"
                                    class="w-full aspect-square object-cover" alt="{{ $banner->title }}">
                                <div
                                    class="absolute bottom-0 left-0 right-0 p-2 bg-black/50 text-white text-sm flex justify-between items-center">
                                    <div>
                                        <p>{{ $banner->title ?? 'No Title' }}</p>
                                    </div>
                                    <form action="{{ route('banners.destroy', $banner->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded text-xs">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <!-- cards row 3 -->

        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" id="bannersForm">
            @csrf
            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-12/12 lg:flex-none">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                        <!-- Header -->
                        <div class="p-4 pb-0 mb-0 rounded-t-4 flex justify-between items-center">
                            <h6 class="mb-2 dark:text-white">Banners</h6>
                            <button type="button" id="addBannerBtn"
                                class="px-3 py-1 text-sm font-semibold text-white bg-blue-500 rounded-xl hover:bg-blue-600">
                                Add Banner
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="overflow-x-auto p-4" id="bannerContainer">
                            <div class="text-center text-gray-400 py-10" id="emptyMessage">
                                Upload banner first
                            </div>
                            <!-- JS will append banner items here -->
                        </div>

                        <!-- Submit -->
                        <div class="p-4 border-t border-gray-200 flex justify-end">
                            <button type="submit"
                                class="px-3 py-1 text-sm font-semibold text-white bg-blue-500 rounded-xl hover:bg-blue-600">
                                Save Banners
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Template for a banner item -->
        <template id="bannerItemTemplate">
            <div class="relative w-full h-64 mb-4 rounded-lg overflow-hidden banner-item" draggable="true">
                <!-- Image upload -->
                <input type="file" name="banners[][image]" class="hidden banner-image-input" accept="image/*">
                <img src="{{ asset('assets/img/default-product.jpg') }}"
                    class="w-full h-full object-cover banner-preview cursor-pointer" alt="preview">

                <!-- Title overlay -->
                <div class="absolute bottom-0 left-0 w-full bg-black/50 px-4 py-2 flex justify-center">
                    <input type="text" name="banners[][title]" placeholder="Enter banner title"
                        class="w-full max-w-xl text-white bg-transparent border border-white rounded px-3 py-1 text-sm text-center outline-none banner-title-input">
                </div>

                <!-- Remove button -->
                <button type="button"
                    class="absolute top-2 right-2 px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600 remove-banner-btn">
                    Remove
                </button>

                <!-- Hidden position input -->
                <input type="hidden" name="banners[][position]" class="banner-position-input" value="0">
            </div>
        </template>

        @include('layouts.components.admin-footer')
        <script>
            const addBannerBtn = document.getElementById('addBannerBtn');
            const bannerContainer = document.getElementById('bannerContainer');
            const bannerTemplate = document.getElementById('bannerItemTemplate');
            const emptyMessage = document.getElementById('emptyMessage');
            const bannersForm = document.getElementById('bannersForm');
            let draggedItem = null;

            function toggleEmptyMessage() {
                emptyMessage.style.display = bannerContainer.querySelectorAll('.banner-item').length ? 'none' : 'block';
            }

            // Update positions before submit
            bannersForm.addEventListener('submit', () => {
                Array.from(bannerContainer.querySelectorAll('.banner-item')).forEach((item, idx) => {
                    item.querySelector('.banner-position-input').value = idx;
                });
            });

            addBannerBtn.addEventListener('click', () => {
                const clone = bannerTemplate.content.cloneNode(true);
                bannerContainer.appendChild(clone);
                toggleEmptyMessage();

                const lastItem = bannerContainer.lastElementChild;
                const img = lastItem.querySelector('.banner-preview');
                const input = lastItem.querySelector('.banner-image-input');
                const removeBtn = lastItem.querySelector('.remove-banner-btn');

                // Image click to open file
                img.addEventListener('click', () => input.click());

                // Preview selected image
                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) img.src = URL.createObjectURL(file);
                });

                // Remove banner
                removeBtn.addEventListener('click', () => {
                    lastItem.remove();
                    toggleEmptyMessage();
                });

                // Drag & drop
                lastItem.addEventListener('dragstart', () => {
                    draggedItem = lastItem;
                    setTimeout(() => lastItem.classList.add('opacity-50'), 0);
                });
                lastItem.addEventListener('dragend', () => {
                    draggedItem.classList.remove('opacity-50');
                    draggedItem = null;
                });
                lastItem.addEventListener('dragover', e => e.preventDefault());
                lastItem.addEventListener('drop', () => {
                    if (draggedItem && draggedItem !== lastItem) {
                        const children = Array.from(bannerContainer.querySelectorAll('.banner-item'));
                        const draggedIndex = children.indexOf(draggedItem);
                        const targetIndex = children.indexOf(lastItem);

                        if (draggedIndex < targetIndex) {
                            bannerContainer.insertBefore(draggedItem, lastItem.nextSibling);
                        } else {
                            bannerContainer.insertBefore(draggedItem, lastItem);
                        }
                    }
                });
            });

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

                // Initialize positions
                updateSlides();
            });


            toggleEmptyMessage();
        </script>

    </div>
@endsection
