@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Create Quiz</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('quiz.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="number_of_discs">Number of Discs</label>
                        <input type="number" class="form-control" id="number_of_discs" name="number_of_discs" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="number_of_tries">Number of Tries</label>
                        <input type="number" class="form-control" id="number_of_tries" name="number_of_tries" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="for_who">For Who</label>
                        <select class="form-control" id="for_who" name="for_who" required>
                            <option value="">Select an option</option>
                            <option value="all">All</option>
                            <option value="guests">Guests</option>
                            <option value="users">Users</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pre_game_link">Pre Game Link</label>
                        <input type="url" class="form-control" id="pre_game_link" name="pre_game_link" required>
                    </div>

                    <div class="form-group">
                        <label for="post_game_link">Post Game Link</label>
                        <input type="url" class="form-control" id="post_game_link" name="post_game_link" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Quiz</button>
                </form>
            </div>
        </div>
    </div>
@endsection

