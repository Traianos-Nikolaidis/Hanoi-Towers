@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $user->name }}'s Stats for "{{ $quiz->name }}"</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Correct Moves</th>
                            <th>Wrong Moves</th>
                            <th>Time Played</th>
                            <th>Date Played</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stats as $stat)
                            <tr>     
                                <td>{{ $stat->correct_moves }}</td>
                                <td>{{ $stat->wrong_moves }}</td>
                                <td>{{ $stat->time_played }}</td>
                                <td>{{ $stat->date_played }}</td>
                                <td>{{ $stat->completed }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $stats->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
