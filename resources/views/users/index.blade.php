@extends('layouts/contentNavbarLayout')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">User Management</h1>
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="input-group w-25">
                    <input type="search" id="search" name="search" class="form-control search-input"
                        placeholder="search here" aria-label="Search">
                    <button type="submit" id="searchBtn" class="btn btn-outline-primary">
                        <i class="bx bx-search"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        @foreach ($users->where('id', '!=', '1') as $user)
                            <tbody class="allData">
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->getRoleNames()->isNotEmpty())
                                            <span class="badge bg-primary">{{ $user->getRoleNames()->implode(', ') }}</span>
                                        @else
                                            <span class="badge bg-secondary">No Role assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if (auth()->user()->hasRole('admin'))
                                                <form action="{{ route('users.assignRole', $user->id) }}" method="POST"
                                                    class="me-2">
                                                    @csrf
                                                    <div class="input-group">
                                                        <select name="role_id" class="form-select form-select-sm">
                                                            @foreach ($roles->where('name', '!=', 'admin') as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                                                    {{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-check"></i> Assign
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs mx-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    onclick="return confirm('Are you sure you want to remove this user?')">
                                                    <i class="bx bx-trash"></i>Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach

                        <tbody id="content" class="searchData"></tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 p-4">
        {{ $users->links('vendor.pagination.bootstrap-5') }}
    </div>

    <!-- Add FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Add Bootstrap Tooltip Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#search').on('keyup', function() {
                $value = $(this).val();
                // alert($value);
                if ($value) {
                    $('.allData').hide();
                    $('.searchData').show();
                } else {
                    $('.allData').show();
                    $('.searchData').hide();
                }

                $.ajax({
                    url: "{{ route('users.search') }}",
                    type: 'GET',
                    data: {
                        'search': $value
                    },

                    success: function(data) {
                        // console.log(data);
                        $('#content').html(data);
                    }
                })
            })

        })
    </script>
@endsection
