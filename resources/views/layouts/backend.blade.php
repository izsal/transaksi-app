<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    @stack('before-styles')

    <script src="{{ asset('js/jquery.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    @stack('after-styles')
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        @include('backend.includes.backend_header')

        @include('backend.includes.backend_sidebar')

        <main id="main" class="main wrapper">
            <div class="pagetitle">
                @yield('title_main')
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        @yield('breadcrumb_item')
                    </ol>
                </nav>
            </div>
            <section class="section dashboard">
                <div class="body flex-grow-1">
                    @include('flash::message')
                    @yield('content')
                </div>
                @include('backend.includes.backend_footer')
            </section>
        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
    </div>

    @stack('before-scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker({
                uiLibrary: 'bootstrap5',
                format: 'yyyy-mm-dd'
            });

            $('.number').on('keydown', (event) => {
                if (event.shiftKey == true) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <=
                        105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event
                    .keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190) event.preventDefault();

                //return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57;
            });
        });
    </script>

    @stack('after-scripts')

</body>

</html>
