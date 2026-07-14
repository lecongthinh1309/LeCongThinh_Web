<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My Web')</title>

    {{-- Sử dụng CSS và JavaScript thông qua Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- SIDEBAR --}}
            <div class="col-md-2 bg-dark text-white p-0">
                @include('admin._partials.sidebar')
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-md-10 d-flex flex-column p-0">
                {{-- HEADER --}}
                <div class="border-bottom bg-white">
                    @include('admin._partials.header')
                </div>

                {{-- MAIN CONTENT --}}
                <main class="flex-grow-1 bg-light p-3">
                    @yield('content')
                </main>

                {{-- FOOTER --}}
                <footer class="bg-dark text-white text-center py-2">
                    @include('admin._partials.footer')
                </footer>
            </div>
        </div>
    </div>


    
    @yield('scripts')
</body>

</html>