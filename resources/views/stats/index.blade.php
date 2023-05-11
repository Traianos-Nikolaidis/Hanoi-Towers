@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Stats</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Correct Moves</th>
                            <th>Wrong Moves</th>
                            <th>Time Played</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userStats as $stat)
                            <tr>
                                <td>
                                    <a href="{{ route('stats.user-quizzes', $stat['user']->id) }}">{{ $stat['user']->name }}</a>
                                </td>  
                                <td>{{ $stat['user']->email }}</td>
                                <td>{{ $stat['stats']['correct_moves'] }}</td>
                                <td>{{ $stat['stats']['wrong_moves'] }}</td>
                                <td>{{ $stat['stats']['time_played'] }}</td>
                                <td>{{ $stat['stats']['completed'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
