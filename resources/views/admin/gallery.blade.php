@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
    <div class="w-full relative px-6 mx-auto mt-6">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                    <!-- Header -->
                    <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0 flex items-center">
                        <p class="mb-0 dark:text-white/80">Gallery</p>

                        <!-- Upload -->
                        <form id="uploadForm" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data"
                            class="ml-auto">
                            @csrf
                            <input type="file" name="images[]" id="image-input" multiple accept="image/*" class="hidden"
                                onchange="this.form.submit()">
                            <label for="image-input"
                                class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                + Add Image
                            </label>
                        </form>
                    </div>

                    <!-- Body -->
                    <div class="flex-auto px-6 pt-6 pb-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($galeris as $galeri)
                                <div
                                    class="relative rounded-lg overflow-hidden shadow-md border border-gray-200 dark:border-slate-700">
                                    <!-- Thumbnail -->
                                    <img src="{{ asset('storage/' . $galeri->path) }}"
                                        class="w-full h-40 object-cover cursor-pointer aspect-square transition-transform duration-300 hover:scale-105"
                                        alt="Gallery Image"
                                        onclick="openImageModal('{{ asset('storage/' . $galeri->path) }}')">

                                    <!-- Delete button -->
                                    <form action="{{ route('gallery.destroy', $galeri->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)" class="absolute top-2 right-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 shadow transition duration-200">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $galeris->links() }}
                        </div>
                    </div>

                    <!-- Modal for expanded image -->
                    <div id="imageModal"
                        class="fixed flex inset-0 bg-black/50 hidden items-center justify-center z-[999] transition-opacity duration-300">
                        <div id="imageModalCard"
                            class="relative max-w-3xl w-full transform scale-95 opacity-0 transition-all duration-300">
                            <img id="modalImage" src="" class="max-h-[80vh] mx-auto rounded-lg shadow-lg">
                            <button onclick="closeImageModal()"
                                class="absolute top-2 right-2 bg-white text-black px-3 py-1 rounded-lg shadow hover:bg-gray-200">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.components.admin-footer')
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

        // Confirm before delete
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm("⚠️ Are you sure you want to delete this image?")) {
                event.target.closest("form").submit();
            }
        }
    </script>

@endsection
