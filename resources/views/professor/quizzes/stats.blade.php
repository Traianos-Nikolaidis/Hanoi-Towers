@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Owned Quizzes Stats</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Quiz Name</th>
                            <th>Average Correct Moves</th>
                            <th>Average Wrong Moves</th>
                            <th>Average Time Played</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizStats as $stat)
                            <tr style="cursor:pointer;" onclick="window.location='{{ route('professor.quizzes.userstats', ['quiz' => $loop->index + 1]) }}'">
                                <td>{{ $stat['quiz_name'] }}</td>
                                <td>{{ round($stat['correct_moves'], 2) }}</td>
                                <td>{{ round($stat['wrong_moves'], 2) }}</td>
                                <td>{{ round($stat['time_played'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection