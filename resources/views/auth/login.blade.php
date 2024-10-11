@extends('auth.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection
@section('content')
<main>
    <div class="content">
        <p class="content__ttl">ログイン</p>
        <form action="/login" method="post">
            @csrf
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
            <button type="submit">ログイン</button>
        </form>
        <div class="navigate-to-register">
            <p class="literal-of-nav">アカウントをお持ちでない方はこちらから</p>
            <a href="{{route('register')}}" class="link-of-nav">会員登録</a>
        </div>
    </div>
</main>
@endsection