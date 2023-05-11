@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Quiz Averages</h1>
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
                        @foreach($averages as $average)
                            <tr>
                                <td>{{ $average['quiz_name'] }}</td>
                                <td>{{ round($average['correct_moves'], 2) }}</td>
                                <td>{{ round($average['wrong_moves'], 2) }}</td>
                                <td>{{ round($average['time_played'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $quizzes->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
