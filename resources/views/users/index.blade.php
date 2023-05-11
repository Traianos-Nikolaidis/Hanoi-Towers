@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>All Users</h1>
                <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                    <div class="form-label">Filter by role:</div>
                    @foreach ($roles as $filterRole)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="roles[]" id="{{ $filterRole }}" value="{{ $filterRole }}" {{ (is_array($selectedRoles) && in_array($filterRole, $selectedRoles)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $filterRole }}">{{ ucfirst($filterRole) }}</label>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('stats.index', 'player_id='.$user->id) }}" class="btn btn-primary">View stats</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->appends(['roles' => $selectedRoles])->links('vendor.pagination.bootstrap-4') }}
                {{ $users->links('vendor.pagination.bootstrap-4') }} <!-- Add the pagination links -->
            </div>
        </div>
    </div>
@endsection
