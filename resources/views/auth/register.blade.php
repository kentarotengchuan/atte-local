@extends('auth.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection
@section('content')
<main>
    <div class="content">
        <p class="content__ttl">会員登録</p>
        <form action="/register" method="post">
            @csrf
            <input type="text" name="name" placeholder="名前">
            @error('name')
            <p class="error-message">
                {{$errors->first('name')}}
            </p>
            @enderror
            <input type="email" name="email" placeholder="メールアドレス">
            @error('email')
            <p class="error-message">
                {{$errors->first('email')}}
            </p>
            @enderror
            <input type="password" name="password" placeholder="パスワード">
            @error('password')
            <p class="error-message">
                {{$errors->first('password')}}
            </p>
            @enderror
            <input type="password" name="password_confirmation" placeholder="確認用パスワード">
            <button type="submit">会員登録</button>
        </form>
        <div class="navigate-to-login">
            <p class="literal-of-nav">アカウントをお持ちの方はこちらから</p>
            <a href="{{route('login')}}" class="link-of-nav">ログイン</a>
        </div>
    </div>
</main>
@endsection