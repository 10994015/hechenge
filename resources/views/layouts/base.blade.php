<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>赫成教育集團</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/menu.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/slick/slick-theme.css"/>
    <script type="text/javascript" src="/slick/slick.min.js"></script>

    @livewireStyles
</head>
<body>
    <div id="loading">
        <div class="logo">
            <div class="border"></div>
            <img src="/images/logo.png" alt="赫成教育" />
        </div>
    </div>
    @include('livewire.components.header')
    <main>{{ $slot }}</main>
    @include('livewire.components.footer')
    @livewireScripts
    <script src='/js/app.js'></script>
    <script>var isHome = false;</script>
    @stack('scripts')
    <script src="/js/header.js"></script>
    <script>
        window.onload = ()=>{
            loading.style.display = "none"
        }
    </script>
</body>
</html>