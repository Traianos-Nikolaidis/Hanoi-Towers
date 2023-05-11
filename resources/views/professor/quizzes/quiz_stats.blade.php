@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Quiz Stats: {{ $quiz->name }}</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>
                            <th>Correct Moves</th>
                            <th>Wrong Moves</th>
                            <th>Time Played</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($count=1)
                        @foreach($stats as $stat)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $stat->player->name }}</td>
                                <td>{{ $stat->correct_moves }}</td>
                                <td>{{ $stat->wrong_moves }}</td>
                                <td>{{ $stat->time_played }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection