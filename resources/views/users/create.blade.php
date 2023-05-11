@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Add User</h1>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @include('users._form', ['user' => new App\Models\User()])
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
