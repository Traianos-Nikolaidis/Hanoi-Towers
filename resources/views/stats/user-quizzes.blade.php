@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $user->name }}'s Quizzes</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->name }}</td>
                                <td>{{ $quiz->start_date }}</td>
                                <td>{{ $quiz->end_date }}</td>
                                <td>
                                    <a href="{{ route('stats.user-quiz-stats', ['user' => $user->id, 'quiz' => $quiz->id]) }}" class="btn btn-info">View Stats</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $quizzes->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
