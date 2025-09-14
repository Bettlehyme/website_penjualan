@extends('layouts.user')

@section('title', 'Home')

@section('content')


    <div class="relative flex min-h-screen p-0 overflow-hidden bg-center bg-cover">
        <div class="container z-1 mt-30">
            <div class="flex flex-col md:flex-col lg:flex-col">

                <div class=" p-4 text-center">
                    <h1 class=" md:text-2xl lg:text-4xl font-bold text-gray-900">{{ $article->title }}</h1>
                </div>



                <!-- Right: article Details -->
                <div class="grid grid-cols-1 w-full sm:grid-cols-2 lg:grid-cols-3 ">
                    <!-- Subtitle -->
                    <div
                        class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3 text-center">
                        <h2 class="text-xl">{{ $article->subtitle }}</h2>
                    </div>
                    <!-- Desc -->
                    <div
                        class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3 ">
                        <p>{{ $article->description }}</p>
                    </div>
                    <!-- Image -->
                    <div
                        class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3 ">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image"
                            class="w-full h-auto rounded-lg shadow-lg">

                    </div>
                    <!-- Actions -->
                    <div
                        class=" flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 col-span-1 sm:col-span-2 lg:col-span-3 mt-10">
                        <button onclick="sharearticle()"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center flex items-center justify-center transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                            <i class="fa-solid fa-share-nodes mr-2"></i>
                            Share
                        </button>
                        <a href="https://wa.me/085271744687?text=I'm%20interested%20in%20your%20article"
                            class="bg-purple-500 text-white px-4 py-2 rounded-lg transition text-center transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                            <i class="fa-brands fa-whatsapp mr-2"></i>
                            Konsultasi
                        </a>
                    </div>

                </div>

            </div>

            <div class="border-b"></div>
            <div class="w-full flex flex-col items-start  mb-6">
                <h3 class="pt-8 text-center text-md">Rekomendasi</h3>
                <div class="w-8 h-2 bg-purple-500">
                </div>
            </div>
            <div class="w-full max-w-full grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4 mt-6">
                @foreach ($products as $p)
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
                            {{-- <div class="absolute top-0 bottom-0 right-0 flex items-end  w-1/2">
                                    <div
                                        class="flex justify-center bg-purple-500/70 text-white w-full h-fit font-semibold  py-2 px-4 md:py-3 md:px-3 lg:py-3 lg:px-3 rounded-tl-lg hover:bg-purple-700 transition-colors ">
                                        <span class="text-xs sm:text-xs md:text-md lg:text-lg ">
                                            {{ rupiah($p->price) }}</span>
                                    </div>
                                </div> --}}
                            <img src="{{ asset('storage/' . $p->images[0]->path) }}" alt="{{ $p->title }}"
                                class="w-full aspect-video lg:aspect-video  object-cover">

                            <!-- Hover overlay -->
                            <a href="{{ route('product-page', encrypt($p->product_id)) }}"
                                class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full flex flex-col items-start  mb-6">
                <h3 class="pt-8 text-center text-md">Artikel</h3>
                <div class="w-8 h-2 bg-purple-500">
                </div>
            </div>
            <div class="w-full max-w-full grid grid-cols-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                @foreach ($articles as $a)
                    <a href="{{ route('article-page', encrypt($a->id)) }}">

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

        function sharearticle() {
            if (navigator.share) {
                navigator.share({
                    title: "{{ $article->title }}",
                    text: "Check out this article: {{ $article->title }}",
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
