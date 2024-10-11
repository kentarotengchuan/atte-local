@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection
@section('content')
<main>
    <div class="content">
        <div class="form__changing-date">
            <form action="{{route("subDate",['id'=>$user_id])}}" method="get">
                @csrf
                <input type="hidden" name="date" value={{$date}}>
                <input type="hidden" name="user_id" value={{$user_id}}>
                <button type="submit"><</button>
            </form>
            <p class="current-date">{{$date}}</p>
            <form action="{{route("addDate",['id'=>$user_id])}}" method="get">
                @csrf
                <input type="hidden" name="date" value={{$date}}>
                <input type="hidden" name="user_id" value={{$user_id}}>
                <button type="submit">></button>
            </form>
        </div>
        <div class="history-of-input">
            <table class="history">
                <tr class="table__header">
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach($attendances as $attendance)
                <tr class="table__data">
                    <td>{{$attendance->start_work}}</td>
                    <td>{{$attendance->end_work}}</td>
                    <td>{{$attendance->sumBreakTimes()}}</td>
                    <td>{{$attendance->sumWorkTimes()}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="paginate">
            {{$attendances->appends(Request::all())->links()}}
        </div>
    </div>
</main>
@endsection