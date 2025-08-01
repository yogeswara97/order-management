<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BALI BACI | {{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('quill/quill.css') }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        /* Menghilangkan panah di input type number untuk browser berbasis Webkit (Chrome, Safari, dll) */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Menghilangkan panah di input type number untuk Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Tambahan CSS opsional untuk memastikan tampilan yang rapi */
        input[type=number] {
            appearance: textfield;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: hidden;
        }

        .no-scrollbar {
            -ms-overflow-style: hidden;
            /* IE and Edge */
            scrollbar-width: hidden;
            /* Firefox */
        }
    </style>

    @stack('head')

    @stack('styles')
</head>

<body class="h-full text-white flex flex-col">
    <div class="flex-grow flex flex-col">
        <x-navbar></x-navbar>
        <x-sidebar></x-sidebar>

        <main class="mt-10 sm:mt-20 min-h-[calc(100vh-138px)]">
            <div class="p-4 sm:ml-52 xl:ml-64">
                {{ $slot }}
            </div>
        </main>

        <x-footer></x-footer>
    </div>

    @stack('scripts')

    <script>
        // Select all input fields of type number
        const numberInputs = document.querySelectorAll('input[type="number"]');

        // Function to prevent wheel event on number inputs
        function preventWheel(event) {
            event.preventDefault();
        }

        // Add event listener to each number input
        numberInputs.forEach(input => {
            input.addEventListener('wheel', preventWheel);
        });
    </script>
</body>

</html>
