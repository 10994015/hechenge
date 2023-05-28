<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>赫成教育集團</title>
    @livewireStyles
</head>
<body>
    
    <main>{{ $slot }}</main>
    @stack('scripts')
    @livewireScripts
    
</body>
</html>