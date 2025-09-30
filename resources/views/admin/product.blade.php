@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="w-full relative px-6 mx-auto mt-6">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full  px-3 shrink-0 md:w-8/12 md:flex-0">
                <div class="flex flex-wrap -mx-3">
                    <div class="flex-none w-full max-w-full px-3">
                        <div
                            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                            <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                                <div class="flex items-center">
                                    <p class="mb-0 dark:text-white/80">Product</p>
                                    <button type="button" id="openModalBtn"
                                        class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Add
                                        Product</button>
                                </div>
                            </div>

                            <div class="flex-auto px-0 pt-0 pb-2">
                                <div class="p-0 overflow-x-auto">
                                    <table
                                        class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                        <thead class="align-bottom">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Title
                                                </th>
                                                <th
                                                    class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Brand
                                                </th>
                                                <th
                                                    class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Model
                                                </th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Year
                                                </th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Price
                                                </th>
                                                <th
                                                    class="px-6 py-3 font-bold text-center uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr class="cursor-pointer hover:bg-slate-100" onclick="showProduct(this)"
                                                    data-id="{{ $product->product_id }}" data-title="{{ $product->title }}"
                                                    data-subtitle="{{ $product->subtitle }}"
                                                    data-description="{{ $product->description }}"
                                                    data-brand="{{ $product->brand }}" data-model="{{ $product->model }}"
                                                    data-year="{{ $product->year }}" data-price="{{ $product->price }}"
                                                    data-articleimage="{{ $product->articleimage }}"
                                                    data-images="{{ $product->images->pluck('path')->implode(',') }}">
                                                    <td
                                                        class="px-6 p-2 align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <div class="flex flex-col">
                                                            <h6 class="mb-0 text-sm font-semibold dark:text-white">
                                                                {{ $product->title }}
                                                            </h6>
                                                            <p
                                                                class="mb-0 text-xs text-slate-400 dark:text-white dark:opacity-80">
                                                                {{ Str::limit($product->description, 40) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 p-2 align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <span
                                                            class="text-xs font-semibold dark:text-white">{{ $product->brand }}</span>
                                                    </td>
                                                    <td
                                                        class="px-6 p-2 align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <span
                                                            class="text-xs font-semibold dark:text-white">{{ $product->model }}</span>
                                                    </td>
                                                    <td
                                                        class="px-6 p-2 text-center align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <span
                                                            class="text-xs font-semibold text-slate-400 dark:text-white">{{ $product->year }}</span>
                                                    </td>
                                                    <td
                                                        class="px-6 p-2 text-center align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <span class="text-xs font-semibold text-green-600 dark:text-white">
                                                            {{ rupiah($product->price) }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="p-2 text-center align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                        <button
                                                            class="editProductBtn  text-sm font-semibold hover:underline ml-2"
                                                            data-product='@json($product)'>
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('product.destroy', $product->product_id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-sm font-semibold  hover:underline ml-2">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- Pagination --}}
                                    <div class="mt-4 px-4">
                                        {{ $products->links() }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-0 md:mt-0">
                <div id="product-card"
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border overflow-hidden">
                    <div class="p-6 text-center">
                        <h5 id="preview-title" class="text-xl font-bold text-slate-800">Select a product</h5>
                    </div>
                    <!-- Full-width Square Main Image -->
                    <div class="relative w-full" style="padding-top: 100%;">
                        <img id="preview-main-image" class="absolute top-0 left-0 w-full h-full object-cover"
                            src="{{ asset('assets/img/home-image-1.jpeg') }}" alt="product image">
                    </div>

                    <!-- Thumbnails / carousel -->
                    <div id="preview-thumbnails" class="flex justify-center mt-4 space-x-2">
                        <img src="{{ asset('assets/img/home-image-1.jpeg') }}"
                            class="h-12 w-12 rounded border border-slate-300 object-cover" alt="placeholder">
                    </div>

                    <div class="p-6 text-center">
                        <h5 id="preview-subtitle" class="text-xl font-bold text-slate-800">Select a product</h5>
                        <p id="preview-description" class="text-sm text-slate-500">Product details will appear here.</p>
                        <div class="relative w-full" style="padding-top: 100%;">
                            <iframe id="preview-article-pdf" class="absolute top-0 left-0 w-full h-full hidden"
                                style="border:none;"></iframe>

                            <img id="preview-article-image" class="absolute top-0 left-0 w-full h-full object-cover hidden"
                                src="{{ asset('assets/img/signin-image.jpeg') }}" alt="product image">
                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-4 text-left text-sm text-slate-600">
                            <p><strong>Brand:</strong> <span id="preview-brand">-</span></p>
                            <p><strong>Model:</strong> <span id="preview-model">-</span></p>
                            <p><strong>Year:</strong> <span id="preview-year">-</span></p>
                            <p><strong>Price:</strong> $<span id="preview-price">0.00</span></p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- Modal -->
        <div id="productModal"
            class="fixed inset-0 z-[999] hidden flex items-center justify-center bg-black/50 
       transition-opacity duration-300 opacity-0">

            <!-- Modal card -->
            <div
                class="absolute bg-white dark:bg-slate-850 rounded-2xl overflow-hidden shadow-xl max-w-4xl w-fit p-6 
        transform transition-all duration-300 opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/20 pb-4 mb-4">
                    <h2 id="modalTitle" class="text-lg font-bold text-slate-700 dark:text-white/80">Add Product</h2>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                        ✕
                    </button>
                </div>

                <!-- Body -->
                <div class="flex-auto max-h-[70vh] overflow-y-auto   pr-2">

                    {{-- ✅ Start the form --}}
                    <form id="productForm" action="{{ route('product.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="productId" name="id">
                        <input type="hidden" id="imageOrder" name="image_order">
                        <input type="hidden" id="deletedImages" name="deleted_images">

                        <div class="flex flex-wrap  overflow-x-hidden pb-10">
                            <!-- Upload Images -->
                            <div class="w-full max-w-full px-3 md:w-12/12">
                                <div class="mb-4"> <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80"> Upload
                                        Images </label>
                                    <div id="drop-area"
                                        class="flex flex-wrap items-center gap-3 px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
                                        <input type="file" name="images[]" id="image-input" multiple accept="image/*"
                                            onchange="previewImages(event)" class="hidden" /> <label for="image-input"
                                            class="flex items-center justify-center w-24 h-24 border-2 border-dashed border-gray-400 rounded-lg text-gray-500 cursor-pointer hover:border-blue-500">
                                            + </label>
                                        <div id="preview-container" class="flex flex-wrap gap-3"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Year -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Year</label>
                                    @php $years = range(1900, strftime("%Y", time())); @endphp
                                    <select id="yearInput" name="year"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Brand -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Brand</label>
                                    <input id="brandInput" type="text" name="brand" placeholder="Ex. Toyota"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- Model -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Model</label>
                                    <input id="modelInput" type="text" name="model" placeholder="Ex. Avanza"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Price</label>
                                    <input id="priceInput" type="number" name="price" placeholder="Ex. 200000000"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="w-full max-w-full px-3 md:w-12/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Title</label>
                                    <input id="titleInput" type="text" name="title"
                                        placeholder="Ex. Toyota Avanza 2020"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 
                                border border-gray-300 rounded-lg outline-none 
                                dark:bg-slate-850 dark:text-white 
                                focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>
                            <!-- Sub Title -->
                            <div class="w-full max-w-full px-3 md:w-12/12">
                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Sub
                                        Title</label>
                                    <input id="subtitleInput" type="text" name="subtitle"
                                        placeholder="Ex. More Efficient"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 
                                border border-gray-300 rounded-lg outline-none 
                                dark:bg-slate-850 dark:text-white 
                                focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="w-full max-w-full px-3 md:w-12/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Description</label>
                                    <textarea id="descriptionInput" name="description" placeholder="Ex. This is a good car"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 md:w-12/12">
                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">
                                        Article PDF / Image
                                    </label>
                                    <input id="articleimageInput" type="file" name="articleimage"
                                        accept="application/pdf,image/*"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 
             border border-gray-300 rounded-lg outline-none 
             dark:bg-slate-850 dark:text-white 
             focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="fixed flex w-full p-5 bg-white shadow-md  justify-end gap-2 bottom-0 left-0 rigth-0">
                            <button type="button" id="cancelModalBtn"
                                class="inline-block px-8 py-2 font-bold text-center text-white bg-gray-500 rounded-lg text-xs hover:shadow-md">
                                Cancel
                            </button>
                            <button type="submit" id="saveBtn"
                                class="inline-block px-8 py-2 font-bold text-center text-white bg-blue-500 rounded-lg text-xs hover:shadow-md">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        @include('layouts.components.admin-footer')

    </div>
    <!-- Vanilla JS for modal -->
    <script>
        let draggedItem = null;
        const productModal = document.getElementById('productModal');
        const modalTitle = document.getElementById('modalTitle');
        const productForm = document.getElementById('productForm');
        const modalCard = productModal.querySelector('div');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');

        // --- Open modal ---
        function openModal() {
            productModal.classList.remove('hidden');
            setTimeout(() => {
                productModal.classList.remove('opacity-0');
                modalCard.classList.remove('opacity-0', 'scale-95');
            }, 10);
        }

        // --- Close modal ---
        function closeModal() {
            productModal.classList.add('opacity-0');
            modalCard.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                productModal.classList.add('hidden');
            }, 300);
        }

        // --- Reset for Add mode ---
        function resetForm() {
            productForm.reset();
            productForm.action = "{{ route('product.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('productId').value = '';
            modalTitle.textContent = "Add Product";

            // ✅ Clear image previews
            document.getElementById('preview-container').innerHTML = "";

            // ✅ Reset hidden fields
            document.getElementById('imageOrder').value = "[]";
            document.getElementById('deletedImages').value = "[]";
        }


        // --- Setup Edit Mode ---
        function setEditMode(product) {
            resetForm();
            modalTitle.textContent = "Edit Product";
            productForm.action = `/product/${product.product_id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('productId').value = product.product_id;

            // Populate fields
            document.getElementById('titleInput').value = product.title;
            document.getElementById('subtitleInput').value = product.subtitle;
            document.getElementById('yearInput').value = product.year;
            document.getElementById('brandInput').value = product.brand;
            document.getElementById('modelInput').value = product.model;
            document.getElementById('priceInput').value = product.price;
            document.getElementById('descriptionInput').value = product.description;

            // ✅ Show existing images
            const container = document.getElementById('preview-container');
            container.innerHTML = "";

            if (product.images && product.images.length > 0) {
                product.images.forEach((img, index) => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "relative h-full cursor-move";
                    wrapper.draggable = true;
                    wrapper.dataset.index = index;
                    wrapper.dataset.id = img.id; // DB id of the image

                    const imageTag = document.createElement("img");
                    imageTag.src = `/storage/${img.path}`;
                    imageTag.className = "w-24 h-24 object-cover rounded-lg border border-gray-300 shadow-sm";

                    const label = document.createElement("span");
                    label.textContent = index + 1;
                    label.className = "absolute top-1 left-1 bg-blue-600 text-white text-xs px-1 rounded";

                    // ❌ delete button
                    const delBtn = document.createElement("button");
                    delBtn.innerHTML = "✕";
                    delBtn.type = "button";
                    delBtn.className =
                        "absolute top-1 right-1 bg-red-600 text-white text-xs px-1 rounded hover:bg-red-700";
                    delBtn.onclick = () => {
                        wrapper.dataset.deleted = "true"; // ✅ mark as deleted
                        wrapper.style.display = "none"; // hide from UI but keep in DOM
                        updateLabels();
                    };

                    wrapper.appendChild(imageTag);
                    wrapper.appendChild(label);
                    wrapper.appendChild(delBtn);
                    enableDrag(wrapper, container);

                    container.appendChild(wrapper);
                });
            }

        }


        // --- Bind Close Buttons ---
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Click outside modal closes
        productModal.addEventListener('click', (e) => {
            if (e.target === productModal) closeModal();
        });

        // --- Add button example ---
        document.getElementById('openModalBtn')?.addEventListener('click', () => {
            resetForm();
            openModal();
        });

        // --- Edit button binding ---
        document.querySelectorAll('.editProductBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const product = JSON.parse(btn.dataset.product);
                setEditMode(product);
                openModal();
            });
        });

        function previewImages(event) {
            const container = document.getElementById('preview-container');
            container.innerHTML = ""; // clear previews

            Array.from(event.target.files).forEach((file, index) => {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement("div");
                    const delBtn = document.createElement("button");

                    wrapper.className = "relative  h-full cursor-move";
                    wrapper.draggable = true;
                    wrapper.dataset.index = index;

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "w-24 h-24 object-cover rounded-lg border border-gray-300 shadow-sm";

                    const label = document.createElement("span");
                    label.textContent = index + 1; // show number instead of "First"
                    label.className = "absolute top-1 left-1 bg-blue-600 text-white text-xs px-1 rounded";

                    wrapper.appendChild(img);
                    wrapper.appendChild(label);

                    // drag events
                    wrapper.addEventListener("dragstart", () => {
                        draggedItem = wrapper;
                        setTimeout(() => wrapper.classList.add("opacity-50"), 0);
                    });
                    wrapper.addEventListener("dragend", () => {
                        draggedItem.classList.remove("opacity-50");
                        draggedItem = null;
                        updateLabels();
                    });
                    wrapper.addEventListener("dragover", e => e.preventDefault());
                    wrapper.addEventListener("drop", () => {
                        if (draggedItem !== wrapper) {
                            const children = Array.from(container.children);
                            const draggedIndex = children.indexOf(draggedItem);
                            const targetIndex = children.indexOf(wrapper);

                            if (draggedIndex < targetIndex) {
                                container.insertBefore(draggedItem, wrapper.nextSibling);
                            } else {
                                container.insertBefore(draggedItem, wrapper);
                            }
                            updateLabels();
                        }
                    });

                    delBtn.innerHTML = "✕";
                    delBtn.type = "button";
                    delBtn.className =
                        "absolute top-1 right-1 bg-red-600 text-white text-xs px-1 rounded hover:bg-red-700";
                    delBtn.onclick = () => {
                        wrapper.remove();
                        updateLabels();
                    };
                    wrapper.appendChild(delBtn);


                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function enableDrag(wrapper, container) {
            wrapper.addEventListener("dragstart", () => {
                draggedItem = wrapper;
                setTimeout(() => wrapper.classList.add("opacity-50"), 0);
            });
            wrapper.addEventListener("dragend", () => {
                draggedItem.classList.remove("opacity-50");
                draggedItem = null;
                updateLabels();
            });
            wrapper.addEventListener("dragover", e => e.preventDefault());
            wrapper.addEventListener("drop", () => {
                if (draggedItem !== wrapper) {
                    const children = Array.from(container.children);
                    const draggedIndex = children.indexOf(draggedItem);
                    const targetIndex = children.indexOf(wrapper);

                    if (draggedIndex < targetIndex) {
                        container.insertBefore(draggedItem, wrapper.nextSibling);
                    } else {
                        container.insertBefore(draggedItem, wrapper);
                    }
                    updateLabels();
                }
            });
        }

        function updateLabels() {
            const container = document.getElementById('preview-container');
            const order = [];
            const deleted = [];

            Array.from(container.children).forEach((child, idx) => {
                if (child.dataset.deleted === "true") {
                    if (child.dataset.id) deleted.push(child.dataset.id);
                    return; // skip deleted from order
                }

                const label = child.querySelector("span");
                if (label) label.textContent = idx + 1;

                if (child.dataset.id) {
                    order.push({
                        id: child.dataset.id,
                        position: idx + 1
                    });
                } else if (child.dataset.tempId) {
                    order.push({
                        tempId: child.dataset.tempId,
                        position: idx + 1
                    });
                }
            });

            document.getElementById("imageOrder").value = JSON.stringify(order);
            document.getElementById("deletedImages").value = JSON.stringify(deleted);

            // 🔍 Debug
            console.log("Order sent:", order);
            console.log("Deleted sent:", deleted);
        }





        function showProduct(row) {
            const card = document.getElementById("product-card");

            // Fill text data
            document.getElementById("preview-title").textContent = row.dataset.title;
            document.getElementById("preview-subtitle").textContent = row.dataset.subtitle;
            document.getElementById("preview-description").textContent = row.dataset.description;
            document.getElementById("preview-brand").textContent = row.dataset.brand;
            document.getElementById("preview-model").textContent = row.dataset.model;
            document.getElementById("preview-year").textContent = row.dataset.year;
            document.getElementById("preview-price").textContent = row.dataset.price;

            // Handle images
            const mainImage = document.getElementById("preview-main-image");
            const thumbnails = document.getElementById("preview-thumbnails");

            thumbnails.innerHTML = ''; // clear previous thumbnails
            const articleFile = row.dataset.articleimage ? row.dataset.articleimage : '';

            const images = row.dataset.images ? row.dataset.images.split(',') : [];

            if (images.length > 0) {
                mainImage.src = `/storage/${images[0]}`; // first image as main
                images.forEach(img => {
                    const thumb = document.createElement('img');
                    thumb.src = `/storage/${img}`;
                    thumb.className =
                        'h-12 w-12 rounded border border-slate-300 cursor-pointer object-cover hover:ring-2 hover:ring-cyan-500';
                    thumb.onclick = () => {
                        mainImage.src = `/storage/${img}`;
                    };
                    thumbnails.appendChild(thumb);
                });
            } else {
                mainImage.src = `/assets/img/default-product.png`;
            }

            // Handle article image or PDF
            const pdfViewer = document.getElementById("preview-article-pdf");
            const imgViewer = document.getElementById("preview-article-image");

            if (articleFile && articleFile.toLowerCase().endsWith(".pdf")) {
                const encoded = encodeURIComponent(`/storage/${articleFile}`);
                pdfViewer.src = `https://docs.google.com/gview?url=${window.location.origin}${encoded}&embedded=true`;
                pdfViewer.classList.remove("hidden");
                imgViewer.classList.add("hidden");
            } else if (articleFile) {
                imgViewer.src = `/storage/${articleFile}`;
                imgViewer.classList.remove("hidden");
                pdfViewer.classList.add("hidden");
            } else {
                imgViewer.src = `/assets/img/default-product.png`;
                imgViewer.classList.remove("hidden");
                pdfViewer.classList.add("hidden");
            }

            // Show card
            card.classList.remove("hidden");
        }
    </script>
@endsection
