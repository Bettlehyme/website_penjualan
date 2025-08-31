@extends('layouts.user')

@section('title', 'Home')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <div class="flex flex flex-col md:flex-col lg:flex-row">

                <!-- Left: Product Image Slider -->
                <div class=" aspect-square max-w-full top-1 w-12/12 md:w-5/12 lg:w-5/12  mr-5">
                    <div
                        class="relative w-full w-full  overflow-hidden rounded-2xl bg-gray-100 flex items-center justify-center">

                        <!-- Images Wrapper -->
                        <div slider class="relative w-full aspect-square overflow-hidden rounded-2xl   ">
                            @foreach ($product->images as $image)
                                <div slide class="absolute w-full h-full transition-all duration-500">
                                    <img class="w-full h-full object-cover cursor-pointer"
                                        src="{{ asset('storage/' . $image->path) }}" alt="banner image"
                                        onclick="openImageModal(this)" />
                                </div>
                            @endforeach
                            <!-- Fullscreen Image Modal -->
                            <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
                                <img id="modalImg" class="zoomable max-w-[90%] max-h-[90%] rounded-lg shadow-lg" />
                            </div>
                            <!-- Control buttons -->
                            <div class="absolute bottom-0 w-full right-0 flex z-20">
                                <div
                                    class="bg-blue-500 text-white w-full text-center font-semibold py-2 px-3 sm:px-4 hover:bg-blue-700 transition-colors">
                                    <span class="text-xl sm:text-4xl md:text-4xl lg:text-3xl">
                                        {{ rupiah($product->price) }}
                                    </span>
                                </div>
                            </div>
                            <button btn-prev
                                class="absolute z-10 w-10 h-10 left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full fa-solid fa-chevron-left active:scale-110"></button>
                            <button btn-next
                                class="absolute z-10 w-10 h-10 right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full fa-solid fa-chevron-right active:scale-110 "></button>
                        </div>
                    </div>
                </div>


                <!-- Right: Product Details -->
                <div class="grid grid-cols-1 w-full sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Title -->
                    <div
                        class="bg-white rounded-xl shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3 transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        <h1 class="text-xl md:text-2xl lg:text-2xl font-bold text-gray-900">{{ $product->title }}</h1>
                    </div>

                    <!-- Brand -->
                    <div
                        class="bg-white rounded-xl shadow-md p-4 transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        <label>Brand</label>
                        <div class="text-gray-700 text-xl font-bold mt-1">{{ $product->brand }}</div>
                    </div>

                    <!-- Model -->
                    <div
                        class="bg-white rounded-xl shadow-md p-4 transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        <label>Model</label>
                        <div class="text-gray-700 font-bold text-xl mt-1">{{ $product->model }}</div>
                    </div>

                    <!-- Year -->
                    <div
                        class="bg-white rounded-xl shadow-md p-4 transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        <label>Year</label>
                        <div class="text-gray-700 font-bold text-xl mt-1">{{ $product->year }}</div>
                    </div>

                    <!-- Description -->
                    <div
                        class="bg-white rounded-xl shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3 
         transition-all ease-in hover:-translate-y-px hover:shadow-xl">

                        <div class="flex flex-row justify-between">
                            <label class="font-semibold">Description</label>
                            <button id="desc-toggle" class="text-blue-500 text-sm mt-1 focus:outline-none hover:underline">
                                Read more
                            </button>
                        </div>

                        <div id="desc-wrapper"
                            class="text-gray-700 text-md font-bold mt-1 overflow-hidden transition-all duration-500 ease-in-out"
                            style="max-height: 3rem;"> <!-- collapsed height -->

                            <p id="desc-text">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>


                    <!-- Actions -->
                    <div
                        class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3 ">
                        <button onclick="shareProduct()"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center flex items-center justify-center transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                            <i class="fa-solid fa-share-nodes mr-2"></i>
                            Share
                        </button>
                        <a href="https://wa.me/085271744687?text=I'm%20interested%20in%20your%20product"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center transition-all ease-in hover:-translate-y-px hover:shadow-xl">
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
                                    class="flex justify-between bg-blue-500 text-white w-fit h-fit text-end font-semibold  py-2 px-2 md:py-3 md:px-3 lg:py-3 lg:px-3 rounded-tl-xl hover:bg-blue-700 transition-colors ">
                                    <span class="text-xs sm:text-xs md:text-md lg:text-lg ">
                                        {{ rupiah($p->price) }}</span>
                                </div>
                            </div>
                            <img src="{{ asset('storage/' . $p->images[0]->path) }}" alt="{{ $p->title }}"
                                class="w-full aspect-video lg:aspect-square object-cover">

                            <!-- Hover overlay -->
                            <a href="{{ route('product-page', encrypt($p->product_id)) }}"
                                class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                View Details
                            </a>
                        </div>

                        <div class="relative p-4 flex-1 flex flex-col justify-between ">
                            <div>
                                <label class="font-semibold text-gray-800 m-0 p-0 text-sm md:text-xl lg:text-xl">
                                    {{ $p->title }}</label>
                                <p
                                    class="text-gray-500 mt-0 text-xs sm:text-sm md:text-md lg:text-lg 
   overflow-hidden text-ellipsis line-clamp-2 sm:line-clamp-3 md:line-clamp-4">
                                    {{ $p->description }}
                                </p>
                            </div>


                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById("desc-wrapper");
            const text = document.getElementById("desc-text");
            const btn = document.getElementById("desc-toggle");

            // --- Resize handler ---
            window.addEventListener("resize", () => {
                sliderWidth = slider.offsetWidth;
                showSlide(currentIndex);
            });

            // --- Description Toggle ---
            if (wrapper && text && btn) {
                const collapsedHeight = 48; // ~3rem

                wrapper.style.maxHeight = collapsedHeight + "px";

                btn.addEventListener("click", () => {
                    const expanded = wrapper.style.maxHeight !== collapsedHeight + "px";

                    if (expanded) {
                        // collapse
                        wrapper.style.maxHeight = collapsedHeight + "px";
                        btn.textContent = "Read more";
                    } else {
                        // expand to full scroll height
                        wrapper.style.maxHeight = text.scrollHeight + "px";
                        btn.textContent = "Read less";
                    }
                });
            }
        });

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

        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImg");

        function openImageModal(img) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            modalImg.src = img.src;

            resetTransform();
        }

        // close modal on background tap
        modal.addEventListener("click", (e) => {
            if (e.target === modal) { // only close if background clicked
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                resetTransform();
            }
        });

        // ===== Pinch & Pan =====
        let scale = 1,
            lastScale = 1;
        let posX = 0,
            posY = 0,
            lastX = 0,
            lastY = 0;
        let startX = 0,
            startY = 0;
        let active = false;

        function resetTransform() {
            scale = 1;
            lastScale = 1;
            posX = 0;
            posY = 0;
            lastX = 0;
            lastY = 0;
            modalImg.style.transform = "translate(0px,0px) scale(1)";
        }

        modalImg.addEventListener("touchstart", e => {
            if (e.touches.length === 2) {
                lastScale = scale;
            } else if (e.touches.length === 1) {
                active = true;
                startX = e.touches[0].pageX - lastX;
                startY = e.touches[0].pageY - lastY;
            }
        });

        modalImg.addEventListener("touchmove", e => {
            e.preventDefault();

            if (e.touches.length === 2) {
                // pinch
                let dx = e.touches[0].pageX - e.touches[1].pageX;
                let dy = e.touches[0].pageY - e.touches[1].pageY;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (!modalImg.initialDistance) {
                    modalImg.initialDistance = distance;
                } else {
                    scale = Math.min(Math.max(lastScale * (distance / modalImg.initialDistance), 1), 4);
                }
            } else if (e.touches.length === 1 && active) {
                // pan
                posX = e.touches[0].pageX - startX;
                posY = e.touches[0].pageY - startY;
            }

            modalImg.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
        });

        modalImg.addEventListener("touchend", e => {
            if (e.touches.length === 0) {
                active = false;
                lastX = posX;
                lastY = posY;
                lastScale = scale;
                modalImg.initialDistance = null;
            }
        });
    </script>


    </div>

@endsection
