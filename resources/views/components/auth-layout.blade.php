<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>BALI BACI | {{ $title }}</title>
    @vite('resources/css/app.css')

</head>

<body class="h-full text-white flex flex-col">

    {{ $slot }}
</body>

</html>
