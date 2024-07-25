@extends('admin::layouts.master')

@section('title', 'Delete User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Delete User</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="search">
                            <form>
                                <label for="search">Search:</label>
                                <input
                                    type="text"
                                    id="search"
                                    name="keyword"
                                    placeholder="Search user by email"
                                    value="{{request()->query('keyword')}}"
                                >
                                <input type="submit" value="Go">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @if (session()->has('success'))
                <div>
                    <p class="success">{{session('success')}}</p>
                </div>
            @endif

            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        @if (!request()->query('keyword'))
                            <p>Enter User Email to Search</p>
                        @elseif (!$users->count())
                            <p>No User found!</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->first_name}}</td>
                                            <td>{{$user->last_name}}</td>
                                            <th scope="row">{{$user->email}}</th>
                                            <td>
                                                <form
                                                    action="{{route('admin.users.delete', $user)}}"
                                                    method="POST"
                                                    onsubmit="return confirm('Do you really want to delete the user?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
