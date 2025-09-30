@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="w-full px-6 py-6 mx-auto">
        <!-- table 1 -->
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <div class="flex items-center">
                            <p class="mb-0 dark:text-white/80">Users</p>
                            <button type="button" id="openModalBtn"
                                class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Add
                                User</button>
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
                                            Name
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                            Email
                                        </th>

                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                            Created
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase bg-transparent border-b text-xxs text-slate-400 opacity-70">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-slate-100 dark:hover:bg-slate-800">
                                            <td
                                                class="px-6 p-2 align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <h6 class="mb-0 text-sm font-semibold dark:text-white">
                                                        {{ $user->name }}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 p-2 align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                <span class="text-xs font-semibold dark:text-white">
                                                    {{ $user->email }}
                                                </span>
                                            </td>

                                            <td
                                                class="px-6 p-2 text-center align-middle border-b dark:border-white/40 whitespace-nowrap">
                                                <span class="text-xs font-semibold text-slate-400 dark:text-white">
                                                    {{ $user->created_at->format('Y-m-d') }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 p-2 text-center align-middle border-b dark:border-white/40 whitespace-nowrap flex items-center justify-center gap-3">

                                                {{-- Edit Button --}}
                                                <button type="button"
                                                    class="editUserBtn inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200"
                                                    data-user='@json($user->only(['id', 'name', 'email']))'>
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                {{-- Delete Form --}}
                                                @if (auth()->id() !== $user->id)
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center w-8 h-8 text-red-300 bg-red-100 rounded-full hover:bg-red-200"
                                                            onclick="return confirm('Delete this user?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="mt-4 px-4">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="addUserModal"
            class="fixed top-0 bottom-0 left-0 right-0 inset-0 z-[999] hidden flex items-center justify-center bg-black/50 
   transition-opacity duration-300 opacity-0">

            <!-- Modal card -->
            <div
                class="absolute bg-white dark:bg-slate-850 rounded-2xl shadow-xl max-w-3xl  p-6 
    transform transition-all duration-300 opacity-0 scale-95">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/20 pb-4 mb-4">
                    <h2 class="text-lg font-bold text-slate-700 dark:text-white/80">Add User</h2>
                    <button onclick="closeModal()" id="closeUserModalBtn"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                        ✕
                    </button>
                </div>

                <!-- Body -->
                <div class="flex-auto max-h-[70vh] w-full overflow-y-none pr-2">

                    {{-- ✅ Start form --}}
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-wrap -mx-3">
                            <!-- Name -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Name</label>
                                    <input type="text" name="name" placeholder="Ex. John Doe"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 
                            border border-gray-300 rounded-lg outline-none 
                            dark:bg-slate-850 dark:text-white 
                            focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Email</label>
                                    <input type="email" name="email" placeholder="Ex. john@example.com"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Password</label>
                                    <input type="password" name="password" placeholder="********"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="w-full max-w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Confirm
                                        Password</label>
                                    <input type="password" name="password_confirmation" placeholder="********"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 placeholder-gray-500 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" id="cancelUserModalBtn" onclick="closeModal()"
                                class="inline-block px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-gray-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-block px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                Save
                            </button>
                        </div>
                    </form>
                    {{-- ✅ End form --}}
                </div>
            </div>
        </div>



        @include('layouts.components.admin-footer')
    </div>
    <script>
        const modal = document.getElementById('addUserModal');
        const modalTitle = modal.querySelector('h2'); // modal title
        const form = modal.querySelector('form');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');
        const modalCard = modal.querySelector('div');

        // Reusable open function
        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalCard.classList.remove('opacity-0', 'scale-95');
            }, 10);
        }

        // Reusable close function
        function closeModal() {
            modal.classList.add('opacity-0');
            modalCard.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Reset form (for Add mode)
        function resetForm() {
            form.reset();
            form.action = "/user"; // default store route
            form.querySelector('input[name="_method"]')?.remove(); // remove method override
            modalTitle.textContent = "Add User";
        }

        // Setup edit mode
        function setEditMode(user) {
            resetForm();
            modalTitle.textContent = "Edit User";
            form.action = `/user/${user.id}`;

            // Add hidden _method for PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);

            // Populate fields
            form.querySelector('input[name="name"]').value = user.name;
            form.querySelector('input[name="email"]').value = user.email;
        }

        // Event bindings
        openBtn?.addEventListener('click', () => {
            resetForm();
            openModal();
        });

        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // For edit buttons in user table
        document.querySelectorAll('.editUserBtn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const user = JSON.parse(btn.dataset.user);
                // Example: <button class="editUserBtn" data-user='{"id":1,"name":"John","email":"john@example.com","role":"admin"}'>Edit</button>
                setEditMode(user);
                openModal();
            });
        });
    </script>
@endsection
