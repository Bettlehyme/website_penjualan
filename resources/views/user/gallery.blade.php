@extends('layouts.user')

@section('title', 'Chery Pekanbaru - Gallery')
@section('meta_title', 'Galeri Mobil Chery Pekanbaru | Tampilan Eksterior & Interior')
@section('meta_description', 'Jelajahi galeri foto mobil Chery di Pekanbaru. Lihat tampilan mewah dan fitur modern Omoda 5, Tiggo 7 Pro, dan Tiggo 8 Pro. Dealer Chery Pekanbaru siap melayani Anda.')
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
                <div class="w-full max-w-full grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-6 gap-6 p-4">
                    @forelse ($gallery as $galeri)
                        <img src="{{ asset('storage/' . $galeri->path) }}"
                            class="w-full h-40 object-cover cursor-pointer aspect-square transition-transform duration-300 hover:scale-105 rounded-lg"
                            alt="Gallery Image" onclick="openImageModal('{{ asset('storage/' . $galeri->path) }}')">


                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            No products found.
                        </div>
                    @endforelse
                </div>
            </div>
            <!-- Modal for expanded image -->
            <div id="imageModal"
                class="fixed flex inset-0 w-[100vw] h-[100vh] overflow-hidden bg-black/50 hidden items-center justify-center z-[999] transition-opacity duration-300">
                <div id="imageModalCard"
                    class="relative max-w-3xl w-full transform scale-95 opacity-0 transition-all duration-300">
                    <img id="modalImage" src="" class="max-h-[80vh] mx-auto rounded-lg shadow-lg">
                   
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
