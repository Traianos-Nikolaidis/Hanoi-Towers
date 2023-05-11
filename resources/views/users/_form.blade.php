<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
</div>
<div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
    </select>
</div>
