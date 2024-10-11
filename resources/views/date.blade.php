@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/date.css')}}">
@endsection
@section('content')
<main>
    <div class="content">
        <div class="form__changing-date">
            <form action="/date/sub-date" method="get">
            @csrf
                <input type="hidden" name="date" value={{$date}}>
                <button type="submit"><</button>
            </form>
            <p class="current-date">{{$date}}</p>
            <form action="/date/add-date" method="get">
            @csrf
                <input type="hidden" name="date" value={{$date}}>
                <button type="submit">></button>
            </form>
        </div>
        <div class="history-of-input">
            <table class="history">
                <tr class="table__header">
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach($attendances as $attendance)
                <tr class="table__data">
                    <td>{{$attendance->user->name}}</td>
                    <td>{{$attendance->start_work}}</td>
                    <td>{{$attendance->end_work}}</td>
                    <td>{{$attendance->sumBreakTimes()}}</td>
                    <td>{{$attendance->sumWorkTimes()}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="paginate">
            {{$attendances->links()}}
        </div>
    </div>
</main>
@endsection