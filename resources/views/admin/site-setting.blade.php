@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <div class="w-full relative px-6 mx-auto mt-6">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="border-black/12.5 rounded-t-2xl border-b p-6">
                        <h2 class="text-lg font-bold dark:text-white/80">Site Settings</h2>
                    </div>

                    <div class="flex-auto p-6">
                        <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Site Logo -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Site
                                    Logo</label>
                                <div class="flex items-center gap-4">
                                    <img id="logoPreview"
                                        src="{{ setting('logo') ? asset('storage/' . setting('logo')) : 'https://via.placeholder.com/100' }}"
                                        class="w-24 h-24 object-cover rounded-lg border border-gray-300" alt="Logo Preview">

                                    <input type="file" name="site_logo" id="site_logo" accept="image/*" class="hidden"
                                        onchange="previewLogo(event)">

                                    <button type="button" onclick="document.getElementById('site_logo').click()"
                                        class="px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600">
                                        Change Logo
                                    </button>
                                </div>
                            </div>

                            <!-- Sales Photo -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Sales
                                    Photo</label>
                                <div class="flex items-center gap-4">
                                    <img id="salesPhotoPreview"
                                        src="{{ setting('sales_photo') ? asset('storage/' . setting('sales_photo')) : 'https://via.placeholder.com/100' }}"
                                        class="w-24 h-24 object-cover rounded-lg border border-gray-300"
                                        alt="Sales Photo Preview">

                                    <input type="file" name="sales_photo" id="sales_photo" accept="image/*"
                                        class="hidden" onchange="previewSalesPhoto(event)">

                                    <button type="button" onclick="document.getElementById('sales_photo').click()"
                                        class="px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600">
                                        Change Sales Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Site Name -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Site
                                    Name</label>
                                <input type="text" name="site_name" value="{{ setting('site_name') }}"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                            </div>

                            <!-- Sales Name -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Sales
                                    Name</label>
                                <input type="text" name="sales_name" value="{{ setting('sales_name') }}"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                            </div>

                            <!-- Sales Description -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Sales
                                    Description</label>
                                <textarea name="sales_description" rows="3"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ setting('sales_description') }}</textarea>
                            </div>

                            <!-- Social Links -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Twitter</label>
                                    <input type="text" name="twitter" value="{{ setting('twitter') }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Instagram</label>
                                    <input type="text" name="instagram" value="{{ setting('instagram') }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">YouTube</label>
                                    <input type="text" name="youtube" value="{{ setting('youtube') }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Facebook</label>
                                    <input type="text" name="facebook" value="{{ setting('facebook') }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">WhatsApp
                                    Number</label>
                                <input type="text" name="whatsapp_number" value="{{ setting('whatsapp_number') }}"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                            </div>

                            <!-- Footer Description -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Footer
                                    Description</label>
                                <textarea name="footer_description" rows="3"
                                    class="block w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg outline-none dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ setting('footer_description') }}</textarea>
                            </div>

                            <!-- Price List (Image Upload) -->
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-700 dark:text-white/80">Price List
                                    (Image)</label>
                                <div class="flex items-center gap-4">
                                    <img id="priceListPreview"
                                        src="{{ setting('price_list') ? asset('storage/' . setting('price_list')) : 'https://via.placeholder.com/100' }}"
                                        class="w-24 h-24 object-cover rounded-lg border border-gray-300"
                                        alt="Price List Preview">

                                    <input type="file" name="price_list" id="price_list" accept="image/*"
                                        class="hidden" onchange="previewPriceList(event)">

                                    <button type="button" onclick="document.getElementById('price_list').click()"
                                        class="px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600">
                                        Change Price List
                                    </button>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end gap-2">
                                <button type="submit"
                                    class="px-6 py-2 text-sm font-bold text-white bg-purple-500 rounded-lg hover:bg-purple-700">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function previewLogo(event) {
                const [file] = event.target.files;
                if (file) {
                    document.getElementById('logoPreview').src = URL.createObjectURL(file);
                }
            }

            function previewSalesPhoto(event) {
                const [file] = event.target.files;
                if (file) {
                    document.getElementById('salesPhotoPreview').src = URL.createObjectURL(file);
                }
            }

            function previewPriceList(event) {
                const [file] = event.target.files;
                if (file) {
                    document.getElementById('priceListPreview').src = URL.createObjectURL(file);
                }
            }
        </script>
        @include('layouts.components.admin-footer')
    </div>
@endsection
