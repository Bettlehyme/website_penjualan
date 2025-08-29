
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/logo.png" />
    <link rel="icon" type="image/png" href="./assets/img/logo.png" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Main Styling -->
    <link href="./assets/css/argon-dashboard-tailwind.css?v=4.0.1" rel="stylesheet" />

</head>

<body
    class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    <!-- sidenav  -->

    @include('layouts.components.admin-sidebar')

    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        <!-- Navbar -->
        @include('layouts.components.admin-navbar')
        <!-- end Navbar -->

        <!-- cards -->
        @yield('content')
        <!-- end cards -->
    </main>

    @if (session('success'))
        <div id="toast-success"
            class="fixed top-5 right-5 z-50 transform transition-all duration-500 translate-x-full opacity-0">
            <div class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div id="toast-error"
            class="fixed top-5 right-5 z-50 transform transition-all duration-500 translate-x-full opacity-0">
            <div class="bg-white text-black border-2 border-red-500 px-4 py-2 rounded-lg shadow-lg max-w-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</body>

<!-- plugin for charts  -->
<script src="./assets/js/plugins/chartjs.min.js" async></script>
<!-- plugin for scrollbar  -->
<script src="./assets/js/plugins/perfect-scrollbar.min.js" async></script>
<!-- main script file  -->
<script src="./assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const successToast = document.getElementById("toast-success");
        const errorToast = document.getElementById("toast-error");

        function showToast(toast) {
            if (!toast) return;
            // Slide in
            setTimeout(() => {
                toast.classList.remove("translate-x-full", "opacity-0");
                toast.classList.add("translate-x-0", "opacity-100");
            }, 100);

            // Hide after 4s
            setTimeout(() => {
                toast.classList.remove("translate-x-0", "opacity-100");
                toast.classList.add("translate-x-full", "opacity-0");
            }, 4000);
        }

        showToast(successToast);
        showToast(errorToast);
    });
</script>

</html>
