@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset("css/users.css")}}">
@endsection
@section('content')
<main>
    <div class="content">
        <div class="users-table">
            <table class="users">
                <tr class="table__header">
                    <th>従業員一覧</th>
                </tr>
                @foreach($users as $user)
                <tr class="table__data">
                    <td>
                        <form action="{{route('detail')}}" method="get">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <button type="submit" name="reset" value="yes">{{$user->name}}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="paginate">
            {{$users->links()}}
        </div>
    </div>
</main>
@endsection