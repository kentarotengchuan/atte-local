@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset("css/stamp.css")}}">
@endsection
@section('content')
<main>
    <div class="content">
        <div class="message">
            <p class="message__text">{{Auth::user()->name}}さんお疲れ様です！</p>
        </div>
        <div class="buttons">
            <form action="/start-work" method="post">
            @csrf
                <button type="submit" {{$canStartWork ? 'class=btn':'class=btn-disabled disabled'}}>勤務開始</button>
            </form>
            <form action="/end-work" method="post">
            @csrf
                <button type="submit" {{ $canEndWork ? 'class=btn':'class=btn-disabled disabled'}}>勤務終了</button>
            </form>
            <form action="/start-break" method="post">
            @csrf
                <button type="submit" {{ $canStartBreak ? 'class=btn':'class=btn-disabled disabled'}}>休憩開始</button>
            </form>
            <form action="/end-break" method="post">
            @csrf
                <button type="submit" {{ $canEndBreak ? 'class=btn':'class=btn-disabled disabled'}}>休憩終了</button>
            </form>
        </div>
    </div>
</main>
@endsection