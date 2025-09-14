<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ setting('logo') ? asset('storage/' . setting('logo')) : 'https://via.placeholder.com/100' }}" />
    <link rel="icon" type="image/png"
        href="{{ setting('logo') ? asset('storage/' . setting('logo')) : 'https://via.placeholder.com/100' }}" />
    <title>{{ setting('site_name') }}</title>

    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Main Styling -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />

</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    <div class="sticky top-0 z-sticky">
        <div class="flex flex-wrap">
            <div class="w-full max-w-full flex-0">
                <!-- Navbar -->
                @include('layouts.components.user-navbar')
            </div>
        </div>
    </div>
    <main class="mt-0 transition-all duration-200 ease-in-out">
        <section>
            @yield('content')
        </section>
    </main>
    <a href="https://wa.me/{{ setting('whatsapp_number') }}?text=Hallo,%20saya%20ingin%20bertanya" target="_blank"
        class="fixed bottom-6 right-6 p-5 flex items-center justify-center font-bold text-md z-[99]
           rounded-full bg-green-500 text-white shadow-lg 
          hover:bg-green-700 hover:shadow-xl transform transition duration-200 hover:-translate-y-1">
        <i class="fab fa-whatsapp fa-2x mr-2"></i>
        Konsultasi
    </a>
    @include('layouts.components.user-footer')
</body>
<!-- plugin for scrollbar  -->
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>
<script src="{{ asset('assets/js/argon-dashboard-tailwind.js') }}" defer></script>


</html>
