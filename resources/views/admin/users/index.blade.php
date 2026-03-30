@extends('admin.layout')

@section('title', 'Users')

@section('content')
    <h1>Users</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Update role</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.users.role', $user) }}" method="post" class="row-actions">
                        @csrf
                        @method('PATCH')
                        <select name="role">
                            <option value="user" @selected($user->role === 'user')>user</option>
                            <option value="admin" @selected($user->role === 'admin')>admin</option>
                        </select>
                        <button type="submit" class="btn" style="padding:4px 10px;">Save</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
