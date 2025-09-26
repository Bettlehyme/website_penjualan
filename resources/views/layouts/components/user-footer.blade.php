<footer class="py-12">
    <div class="container border-t pt-10">
        <div class="flex flex-wrap -mx-3">
            {{-- <a href="/sign-in" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12"> Admin?
            </a> --}}

        </div>
        <div class="flex flex-col md:flex-row lg:flex-row justify-center gap-10  mb-10">
            <div class=" px-3 mt-1 text-center flex-0">
                <div class="max-w-sm mx-auto bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <!-- Image -->
                    <img class="w-full h-20 aspect-[6/5] object-cover"
                        src="{{ setting('sales_photo') ? asset('storage/' . setting('sales_photo')) : 'https://via.placeholder.com/100' }}" alt="Profile Image">

                    <!-- Content -->
                    <div class="p-5 text-center">
                        <!-- Name -->
                        <h2 class="text-xl font-bold text-gray-800">{{ setting('sales_name') }}</h2>

                        <!-- Description -->
                        <p class="mt-2 text-gray-600 text-sm">
                            {{ setting('sales_description') }}
                        </p>

                        <!-- Social Buttons -->
                        <div class="mt-4 flex justify-center gap-3">
                            @if (setting('twitter') != '')
                                <a href="{{ setting('twitter') }}" target="_blank"
                                    class="px-4 py-2 w-15 rounded-full bg-purple-500 text-white text-sm font-medium hover:bg-purple-600 transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if (setting('instagram') != '')
                                <a href="{{ setting('instagram') }}" target="_blank"
                                    class="px-4 py-2 w-15 rounded-full bg-purple-500 text-white text-sm font-medium hover:bg-purple-600 transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if (setting('youtube') != '')
                                <a href="{{ setting('youtube') }}" target="_blank"
                                    class="px-4 py-2 w-15 rounded-full bg-purple-500 text-white text-sm font-medium hover:bg-purple-600 transition">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                            @if (setting('facebook') != '')
                                <a href="{{ setting('facebook') }}" target="_blank"
                                    class="px-4 py-2 w-15 rounded-full bg-purple-500 text-white text-sm font-medium hover:bg-purple-600 transition">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-full w-12/12  md:w-6/12  px-3 mt-1 text-left flex-0">
                <p>{{ setting('footer_description') }} </p>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-12/12  max-w-full px-3 mx-auto mt-1 text-center flex-0">
                <img class="w-full" src="{{ asset('/assets/img/finance-pekanbaru.png') }}" />
            </div>
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0">
                <p class="mb-0 text-slate-400">
                    Copyright ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    {{ setting('site_name') }}
                </p>
            </div>
        </div>
    </div>
</footer>
