@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>My Stats</h1>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Quiz Name</th>
                            <th>Correct Moves</th>
                            <th>Wrong Moves</th>
                            <th>Time Played</th>
                            <th>Date Played</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats as $stat)
                            <tr>
                                <td>{{ $stat->quiz->name }}</td>
                                <td>{{ $stat->correct_moves }}</td>
                                <td>{{ $stat->wrong_moves }}</td>
                                <td>{{ $stat->time_played }}</td>
                                <td>{{ $stat->date_played }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $stats->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('clear-stats') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Clear Personal Stats</button>
            </form>
        </div>
    </div>
@endsection    