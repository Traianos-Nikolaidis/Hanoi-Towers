@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Quiz</h1>
                <table style="text-align: center" class="table">
                    <thead>
                        <tr >
                            <th>id</th>
                            <th>quiz name</th>
                            <th>discs</th>
                            <th>start</th>
                            <th>end</th>
                            <th>
                                @if ($available)
                                    <a href="{{ route('quiz.index') }}" class="btn btn-primary">Show All Quizzes</a>
                                @else
                                    <a href="{{ route('quiz.index', ['available' => 1]) }}" class="btn btn-primary">Show Available Quizzes</a>
                                @endif     
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quiz as $q)
                            @if ($q->player_id == request()->player_id)
                                <tr>
                                    <td>{{ $q->id }}</td>
                                    <td>{{ $q->name }}</td>
                                    <td>{{ $q->number_of_discs }}</td>
                                    <td>{{ $q->start_date }}</td>
                                    <td>{{ $q->end_date }}</td>
                                    <td>
                                        @php
                                            $canPlay = false;
                                            $now = \Carbon\Carbon::now();
                            
                                            if ($q->for_who === 'all' && $now->between($q->start_date, $q->end_date)) {
                                                $canPlay = true;
                                            } elseif ($q->for_who === 'guests' && Auth::guest() && $now->between($q->start_date, $q->end_date)) {
                                                $canPlay = true;
                                            } elseif ($q->for_who === 'users' && Auth::check() && $now->between($q->start_date, $q->end_date)) {
                                                $canPlay = true;
                                            }
                                        @endphp
                            
                                        @if ($canPlay)
                                            <a href="{{ route('play', $q->id) }}" class="btn btn-primary">Play</a>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $quiz->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>
    </div>
@endsection
