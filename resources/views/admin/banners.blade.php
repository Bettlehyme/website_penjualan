@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <!-- cards row 2 -->
        <div class="w-full aspect-[10/3] max-w-full px-3 lg:w-12/12 lg:flex-none">
            <div class="relative w-full h-full aspect-[10/3] overflow-hidden rounded-2xl bg-gray-100 flex items-center justify-center">

                @if ($activeBanners->isNotEmpty())
                    <div slider class="relative w-full h-full aspect-[10/3] overflow-hidden rounded-2xl">
                        @foreach ($activeBanners as $banner)
                            <div slide class="absolute w-full h-full transition-all duration-500">
                                <img class="object-cover h-full aspect-[10/3] w-full" src="{{ asset('storage/' . $banner->image) }}"
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
                <img src="{{ asset('assets/img/add-photo.png') }}"
                    class="w-full h-full object-cover banner-preview cursor-pointer" alt="preview">

                <!-- Title overlay -->
                <div class="absolute bottom-0 left-0 w-full bg-blue-500/50 px-4 py-2 flex justify-center gap-2">
                    <!-- Banner title -->
                    <input type="text" name="banners[][title]" placeholder="Enter banner title"
                        class="w-full max-w-xl text-white font-bold bg-transparent border border-white rounded px-3 py-1 text-sm text-center outline-none banner-title-input">

                    <!-- Hidden input for linkto -->
                    <input type="hidden" name="banners[][link]" class="banner-linkto-input">

                    <!-- Button to open product modal -->
                    <button type="button"
                        class="px-3 py-1 text-sm text-center font-semibold rounded bg-blue-500 text-white hover:bg-blue-800 transition "
                        onclick="openProductModal(this)">
                        Link Product
                    </button>
                </div>

                <!-- Remove button -->
                <button type="button"
                    class="absolute top-2 right-2 px-2 py-1 text-xs text-red-500 bg-red-400 rounded hover:bg-red-600 remove-banner-btn">
                    Remove
                </button>

                <!-- Hidden position input -->
                <input type="hidden" name="banners[][position]" class="banner-position-input" value="0">
            </div>
        </template>

        <div id="productModal" class="fixed inset-0 bg-black/60 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-4">
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-lg font-semibold">Select a Product</h2>
                    <button onclick="closeProductModal()" class="text-gray-500 hover:text-black">&times;</button>
                </div>

                <!-- Product Grid -->
                <div id="productGrid"
                    class="grid grid-cols-2 h-100 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[60vh] overflow-y-auto">
                    @foreach ($products as $p)
                        <div onclick="selectProduct('/product-page/{{ encrypt($p->product_id) }}', '{{ $p->title }}')"
                            class="cursor-pointer border p-2 rounded hover:bg-gray-100 aspect-square">
                            <img src="{{ asset('storage/' . $p->images[0]->path) }}"
                                class="w-full aspect-square object-cover rounded">
                            <p class="mt-2 text-center text-sm">{{ $p->title }}</p>
                        </div>
                    @endforeach

                    <!-- Add dynamically via backend/JS -->
                </div>
            </div>
        </div>

        @include('layouts.components.admin-footer')
        <script>
            const addBannerBtn = document.getElementById('addBannerBtn');
            const bannerContainer = document.getElementById('bannerContainer');
            const bannerTemplate = document.getElementById('bannerItemTemplate');
            const emptyMessage = document.getElementById('emptyMessage');
            const bannersForm = document.getElementById('bannersForm');

            // Toggle empty state
            function toggleEmptyMessage() {
                const items = bannerContainer.querySelectorAll('.banner-item');
                emptyMessage.style.display = items.length ? 'none' : 'block';
            }

            // Reindex banners for form submission
            function reindexBanners() {
                bannerContainer.querySelectorAll('.banner-item').forEach((item, i) => {
                    item.querySelector('.banner-title-input')?.setAttribute('name', `banners[${i}][title]`);
                    item.querySelector('.banner-linkto-input')?.setAttribute('name', `banners[${i}][link]`);
                    item.querySelector('.banner-image-input')?.setAttribute('name', `banners[${i}][image]`);
                    item.querySelector('.banner-position-input')?.setAttribute('name', `banners[${i}][order]`);
                    item.querySelector('.banner-active-input')?.setAttribute('name', `banners[${i}][is_active]`);
                });
            }

            // Update order values before form submit
            bannersForm.addEventListener('submit', () => {
                bannerContainer.querySelectorAll('.banner-item').forEach((item, idx) => {
                    item.querySelector('.banner-position-input').value = idx;
                });
            });

            // Add banner
            addBannerBtn.addEventListener('click', () => {
                const clone = bannerTemplate.content.cloneNode(true);
                bannerContainer.appendChild(clone);
                toggleEmptyMessage();

                const lastItem = bannerContainer.lastElementChild;
                const img = lastItem.querySelector('.banner-preview');
                const input = lastItem.querySelector('.banner-image-input');
                const removeBtn = lastItem.querySelector('.remove-banner-btn');

                // Click preview to open file picker
                img.addEventListener('click', () => input.click());

                // Preview selected image
                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        img.src = URL.createObjectURL(file);
                    }
                });

                // Remove banner
                removeBtn.addEventListener('click', () => {
                    lastItem.remove();
                    toggleEmptyMessage();
                    reindexBanners();
                });

                reindexBanners();
            });

            // ================== PRODUCT MODAL ==================
            let activeLinkInput = null;
            let activeButton = null;

            function openProductModal(button) {
                const container = button.closest('.banner-item');
                activeLinkInput = container.querySelector('.banner-linkto-input');
                activeButton = button;
                document.getElementById('productModal').classList.remove('hidden');
            }

            function closeProductModal() {
                document.getElementById('productModal').classList.add('hidden');
            }

            function selectProduct(productSlug, productTitle) {
                if (activeLinkInput && activeButton) {
                    activeLinkInput.value = productSlug;
                    activeButton.textContent = productTitle;
                }
                closeProductModal();
            }

            

            // Initialize
            toggleEmptyMessage();
        </script>




    </div>
@endsection
