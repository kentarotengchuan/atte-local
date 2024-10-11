<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("css/common.css")}}">
    <link rel="stylesheet" href="{{asset("css/sanitize.css")}}">
    @yield('css')
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header__inner">
            <p class="header__ttl">Atte</p>
        </div>
    </header>
    @yield('content')
    <footer>
        <div class="footer__inner">
            <p class="footer__ttl">Atte,inc.</p>
        </div>
    </footer>
</body>

</html>