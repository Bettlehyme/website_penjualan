@extends('layouts.admin')

@section('title', 'Articles')

@section('content')
    <div class="w-full relative px-6 mx-auto mt-6">
        <div class="flex flex-wrap -mx-3">
            <!-- Articles Table -->
            <div class="w-full md:w-12/12 px-3">
                <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <p class="mb-0 dark:text-white/80">Articles</p>
                        <button type="button" id="openModalBtn"
                            class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                            Add Article
                        </button>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table
                            class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                        Image</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                        Title</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                        Description</th>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70 text-center">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr class="hover:bg-slate-100 dark:hover:bg-slate-700">
                                        <td class="px-4 py-2">
                                            <img src="{{ $article->image ? asset('storage/' . $article->image) : asset('assets/img/default-article.png') }}"
                                                class="w-16 h-16 object-cover rounded-lg">
                                        </td>
                                        <td class="px-4 py-2 font-semibold">{{ $article->title }}</td>
                                        <td class="px-4 py-2 text-sm text-slate-500">
                                            {{ Str::limit($article->description, 60) }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button class="editArticleBtn text-blue-500 mr-2"
                                                data-article='@json($article)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('article.destroy', $article->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>



        </div>
        <!-- Article Modal (fixed IDs) -->
        <div id="articleModal" class="fixed flex inset-0 z-[999] hidden items-center justify-center bg-black/50">
            <!-- Modal card -->
            <div id="articleModalCard"
                class=" bg-white dark:bg-slate-850 right-0  rounded-2xl overflow-hidden shadow-xl max-w-4xl w-full p-6
                transform transition-all duration-300 opacity-0 scale-95">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/20 pb-4 mb-4">
                    <h2 id="articleModalTitle" class="text-lg font-bold text-slate-700 dark:text-white/80">Add Article</h2>
                    <button type="button" id="articleCloseBtn"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-white">✕</button>
                </div>

                <!-- Body -->
                <div class="flex-auto max-h-[70vh] overflow-y-auto pr-2">
                    <form id="articleForm" action="{{ route('article.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="articleId" name="id">

                        <div class="mb-4">
                            <label class="block text-sm font-bold">Title</label>
                            <input type="text" id="titleInput" name="title"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold">Description</label>
                            <textarea id="descriptionInput" name="description"
                                class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" /></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2">Image</label>

                            <!-- Hidden file input -->
                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                                onchange="previewModalImage(event)">

                            <div class="flex flex-row items-center gap-5">

                                <!-- Preview -->
                                <div class="mt-3">
                                    <img id="modalPreviewImage" src="{{ asset('assets/img/add-photo.png') }}"
                                        class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                </div>
                                <!-- Button to trigger file input -->
                                <button type="button" onclick="document.getElementById('imageInput').click()"
                                    class="px-4 py-2 h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Upload Image
                                </button>

                            </div>
                        </div>


                        <div class="flex justify-end gap-2">
                            <button type="button" id="articleCancelBtn"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <!-- Modal -->


    <!-- Put this script after the modal (end of page) -->
    <script>
        (function() {
            // Elements
            const articleModal = document.getElementById('articleModal');
            const articleModalCard = document.getElementById('articleModalCard');
            const articleForm = document.getElementById('articleForm');
            const articleModalTitle = document.getElementById('articleModalTitle');
            const articleCloseBtn = document.getElementById('articleCloseBtn');
            const articleCancelBtn = document.getElementById('articleCancelBtn');
            const imageInput = document.getElementById('imageInput');
            const modalPreviewImage = document.getElementById('modalPreviewImage');

            // --- Open modal ---
            function openArticleModal() {
                articleModal.classList.remove('hidden');
                // allow CSS transition to run
                setTimeout(() => {
                    articleModal.classList.remove('opacity-0');
                    articleModalCard.classList.remove('opacity-0', 'scale-95');
                }, 10);
            }

            // --- Close modal ---
            function closeArticleModal() {
                articleModal.classList.add('opacity-0');
                articleModalCard.classList.add('opacity-0', 'scale-95');
                setTimeout(() => articleModal.classList.add('hidden'), 300);
            }

            // --- Reset for Add mode ---
            function resetArticleForm() {
                // Reset fields and file input
                articleForm.reset();
                if (imageInput) imageInput.value = '';
                articleForm.action = "{{ route('article.store') }}";
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('articleId').value = '';
                articleModalTitle.textContent = "Add Article";
                if (modalPreviewImage) modalPreviewImage.src = "{{ asset('assets/img/add-photo.png') }}";
            }

            // --- Setup Edit Mode ---
            function setArticleEditMode(article) {
                resetArticleForm();
                articleModalTitle.textContent = "Edit Article";
                // adjust action to target the resource (match your routes)
                articleForm.action = `/article/${article.id}`;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('articleId').value = article.id;

                // Populate fields
                document.getElementById('titleInput').value = article.title ?? '';
                document.getElementById('descriptionInput').value = article.description ?? '';

                // Preview existing image (if any)
                if (article.image) {
                    // if article.image is a storage path e.g. "articles/xyz.jpg"
                    modalPreviewImage.src = `/storage/${article.image}`;
                } else {
                    modalPreviewImage.src = "{{ asset('assets/img/default-article.png') }}";
                }
            }

            // --- Image preview for new selection ---
            window.previewModalImage = function(event) {
                if (!event.target.files || !event.target.files[0]) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    modalPreviewImage.src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            };

            // --- Bind close buttons ---
            if (articleCloseBtn) articleCloseBtn.addEventListener('click', closeArticleModal);
            if (articleCancelBtn) articleCancelBtn.addEventListener('click', closeArticleModal);

            // Click outside modal to close
            articleModal.addEventListener('click', (e) => {
                if (e.target === articleModal) closeArticleModal();
            });

            // Close with Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeArticleModal();
            });

            // Attach Add button (if you have a button with id="openModalBtn")
            const openBtn = document.getElementById('openModalBtn');
            if (openBtn) {
                openBtn.addEventListener('click', () => {
                    resetArticleForm();
                    openArticleModal();
                });
            }

            // Attach Edit buttons (if server outputs buttons with class "editArticleBtn" and data-article)
            document.querySelectorAll('.editArticleBtn').forEach(btn => {
                btn.addEventListener('click', (ev) => {
                    ev.stopPropagation(); // prevent row click if needed
                    const data = btn.dataset.article;
                    if (!data) return;
                    try {
                        const article = JSON.parse(data);
                        setArticleEditMode(article);
                        openArticleModal();
                    } catch (err) {
                        console.error('Invalid JSON in data-article:', err);
                    }
                });
            });

            // If you want to support row click showing preview (optional)
            document.querySelectorAll('tr[data-article]').forEach(row => {
                row.addEventListener('click', () => {
                    const data = row.dataset.article;
                    if (!data) return;
                    try {
                        const article = JSON.parse(data);
                        // show card or do something with article
                        console.log('row clicked', article);
                    } catch (err) {
                        /* ignore */
                    }
                });
            });

            // Initialize defaults (if you want modal hidden state handled)
            // resetArticleForm(); // you can uncomment to ensure defaults
        })();
    </script>

@endsection
