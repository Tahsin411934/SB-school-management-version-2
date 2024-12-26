<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.links')
</head>

<body class="font-sans text-gray-900 antialiased">
    @include('includes.navbar')
    <div>
        {{ $slot }}
    </div>
</body>

</html>
