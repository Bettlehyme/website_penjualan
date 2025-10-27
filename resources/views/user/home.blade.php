@extends('layouts.user')

@section('title', 'Chery Pekanbaru')
@section('meta_title', 'Chery Pekanbaru | Dealer Resmi Mobil Chery di Riau')
@section('meta_description', 'Temukan mobil Chery terbaru di Pekanbaru — mulai dari Omoda 5, Tiggo 7 Pro, hingga Tiggo 8
    Pro. Dealer resmi Chery Pekanbaru siap melayani test drive, pembelian tunai, dan kredit mobil Chery dengan promo menarik
    setiap bulan.')
@section('meta_image', asset('assets/img/chery-logo.jpg'))
@section('meta_type', 'website')

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
                                        <a href="{{ $banner->link ?? '#' }}" aria-label="{{$banner->title}}">
                                            <img class="object-cover h-full w-full"
                                                src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"/>
                                        </a>
                                        <div
                                            class="block text-start ml-12 right-10 lg:right-20 bottom-0 absolute pt-5 pb-5 text-white">
                                            @if ($banner->icon)
                                                <div
                                                    class="inline-block w-8 h-8 mb-4 text-center text-black bg-white rounded-lg">
                                                    <i class="{{ $banner->icon }} text-xxs relative text-slate-700"></i>
                                                </div>
                                            @endif
                                            <div
                                                class="w-fit  bg-gradient-to-l from-purple-500/80 via-purple-500/70 to-purple-400/0 px-4 py-4 bg-purple rounded-lg">
                                                <h5 class="mb-1 text-white">{{ $banner->title }}</h5>
                                            </div>
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
                <div class="w-full flex items-center mt-10">
                    <div class="container mx-auto py-10 px-6  lg:px-16 grid grid-cols-1 lg:grid-cols-1 gap-8 h-full">
                      
                        <!-- Right Side (Text) -->
                        <div class="flex flex-col justify-center items-center  md:items-start lg:items-start h-full">
                            <h3 class=" font-bold text-gray-800 mb-4 text-2xl md:text-3xl lg:text-4xl">Temukan Mobil Impian
                                Anda
                            </h3>
                            <p class="text-lg text-gray-600 mb-6 text-center">
                                Temukan mobil Chery terbaru di Pekanbaru — mulai dari Omoda 5, Tiggo 7 Pro, hingga Tiggo 8
                                Pro. Dealer resmi Chery Pekanbaru siap melayani test drive, pembelian tunai, dan kredit
                                mobil Chery dengan promo menarik setiap bulan.
                            </p>
                           
                        </div>
                    </div>
                </div>
                <div class="border-b"></div>
                <div class="w-full flex flex-col items-center  mb-6">
                    <h3 class="pt-8 text-center ">Mobil Terbaru</h3>
                    <div class="w-8 h-2 bg-purple-500">
                    </div>
                </div>

                <div class="w-full max-w-full grid grid-cols-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    {{-- @dd($products  ) --}}
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
                                <img src="{{ asset('storage/' . optional($p->galleryImages->first())->path ?? 'assets/img/default-product.png') }}"
                                    alt="{{ $p->title }}" class="w-full aspect-video object-cover">


                                <!-- Hover overlay -->
                                <a href="{{ route('product-page', $p->title) }}" aria-label="{{$p->title}}"
                                    class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full flex justify-center mt-10">
                    <a href="{{ route('products-catalogue') }}" aria-label="Model"
                        class="inline-block px-20 md:px-40 lg:px-40  py-2 rounded-full bg-white border border-gray-300 text-gray-700 font-bold 
            hover:bg-purple-500 hover:border-gray-400 
            transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        Lihat Semua Mobil
                    </a>
                </div>

                <div class="w-full border-b  mt-10"></div>
                <div class="border-b"></div>
                <div class="w-full flex flex-col items-center mb-6">
                    <h3 class="pt-8 text-center ">Artikel Terbaru</h3>
                    <div class="w-8 h-2 bg-purple-500">
                    </div>
                </div>

                <div class="w-full max-w-full grid grid-cols-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    @foreach ($articles as $a)
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
                    @endforeach
                </div>
                <div class="w-full flex justify-center mt-10">
                    <a href="{{ route('articles-list') }}" aria-label="Artikel"
                        class="inline-block px-20 md:px-40 lg:px-40  py-2 rounded-full bg-white border border-gray-300 text-gray-700 font-bold 
            hover:bg-purple-500 hover:border-gray-400 
            transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                        Lihat Semua Artikel & Promo
                    </a>
                </div>
                <div class="w-full border-b  mt-10"></div>
                <div class="w-full flex flex-col items-center  mb-6">
                    <h3 class="pt-8 text-center ">Unit Hand Over</h3>
                    <div class="w-8 h-2 bg-purple-500">
                    </div>
                    <div class="w-full max-w-full grid grid-cols-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-6 gap-6 p-4">

                        @foreach ($gallery as $galeri)
                            <div
                                class="bg-white rounded-md shadow hover:shadow-lg overflow-hidden flex flex-col shadow-lg transition-all ease-in hover:-translate-y-px hover:shadow-xl">
                                <img src="{{ asset('storage/' . $galeri->path) }}"
                                    class="w-full h-40 object-cover cursor-pointer aspect-square transition-transform duration-300 hover:scale-105 rounded-lg"
                                    alt="Gallery Image"
                                    onclick="openImageModal('{{ asset('storage/' . $galeri->path) }}')">

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="imageModal"
                class="fixed flex inset-0 w-[100vw] h-[100vh] overflow-hidden bg-black/50 hidden items-center justify-center z-[999] transition-opacity duration-300">
                <div id="imageModalCard"
                    class="relative max-w-3xl w-full transform scale-95 opacity-0 transition-all duration-300">
                    <img id="modalImage" src="" class="max-h-[80vh] mx-auto rounded-lg shadow-lg" alt="Modal Image">

                </div>
            </div>
        </div>
        <script>
            const imageModal = document.getElementById('imageModal');
            const imageModalCard = document.getElementById('imageModalCard');

            // Open modal with animation
            function openImageModal(src) {
                document.getElementById('modalImage').src = src;
                imageModal.classList.remove('hidden');
                setTimeout(() => {
                    imageModal.classList.add('opacity-100');
                    imageModalCard.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            // Close modal with animation
            function closeImageModal() {
                imageModal.classList.remove('opacity-100');
                imageModalCard.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    imageModal.classList.add('hidden');
                }, 300);
            }

            // Click outside to close
            imageModal.addEventListener('click', function(e) {
                if (!imageModalCard.contains(e.target)) {
                    closeImageModal();
                }
            });
        </script>

    </div>

@endsection
