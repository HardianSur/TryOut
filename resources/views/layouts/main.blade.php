<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-50 dark:bg-gray-900">
    @if (session('access_token'))
        @include('layouts.header')
    @endif
    <main class="my-4 mx-10 lg:mx-20 lg:my-14">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
