@extends('layouts.adminLayout')

@section('title', 'Index Page')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Success and error messages -->
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- User table -->
                <table class="table table-striped table-bordered" id="userTableBody">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                <td>
                                    @if (auth()->check() && auth()->user()->role == 'admin')
                                        <!-- Role selection form -->
                                        <form action="/user-rolechange/{{ $item->id }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" class="form-control form-control-sm" onchange="this.form.submit()">
                                                <option value="show" {{ $item->role == 'show' ? 'selected' : '' }}>Show</option>
                                                <option value="delete" {{ $item->role == 'delete' ? 'selected' : '' }}>Delete</option>
                                                <option value="edit" {{ $item->role == 'edit' ? 'selected' : '' }}>Edit</option>
                                                <option value="create" {{ $item->role == 'create' ? 'selected' : '' }}>Create</option>
                                                <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </form>
                                    @else
                                        {{ $item->role }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination links -->
                {{ $users->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
