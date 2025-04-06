@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover mt-3">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form id="status-form-{{ $user->id }}" action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="form-inline">
                            @csrf
                            <div class="d-flex align-items-center">
                                <select name="status" class="form-control mr-2">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <button type="button" onclick="confirmStatusChange({{ $user->id }})" class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <form id="role-form-{{ $user->id }}" action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="form-inline">
                            @csrf
                            <div class="d-flex align-items-center">
                                <select name="role" class="form-control mr-2">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="button" onclick="confirmRoleChange({{ $user->id }})" class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function confirmStatusChange(userId) {
        if (confirm('Are you sure you want to change this user\'s status?')) {
            document.getElementById('status-form-' + userId).submit();
        }
    }

    function confirmRoleChange(userId) {
        if (confirm('Are you sure you want to change this user\'s role?')) {
            document.getElementById('role-form-' + userId).submit();
        }
    }
</script>
@endsection