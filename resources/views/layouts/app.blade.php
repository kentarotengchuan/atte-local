<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    @yield('css')
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header__inner">
            <p class="header__ttl">Atte</p>
            <div class="header__nav">
                <form action="/" method="get">
                    @csrf
                    <button type="submit">ホーム</button>
                </form>
                <form action="/date" method="get">
                    @csrf
                    <button type="submit" name="reset" value="yes">日付一覧</button>
                </form>
                <form action="/users" method="get">
                    @csrf
                    <button type="submit">ユーザー一覧</button>
                </form>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>

            </div>
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