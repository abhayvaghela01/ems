@extends('layouts.contentNavbarLayout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<div class="container mt-4">
    <!-- Notification Bell -->
    <div class="position-absolute top-0 end-0 m-3">
        <div class="position-relative d-inline-block">
            <i class="fas fa-bell fa-2x text-danger" id="taskNotificationIcon" style="cursor: pointer;"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="taskNotificationBadge">0</span>
        </div>
        <!-- Notification Dropdown -->
        <div id="notificationDropdown" class="card shadow-sm p-2 position-absolute end-0 mt-2 bg-white border rounded d-none" style="width: 300px; z-index: 1000;">
            <ul class="list-unstyled mb-0" id="notificationList"></ul>
        </div>
    </div>
</div>

<h2 class="mb-4 text-primary fw-bold">Tasks</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <!-- Task Table -->
            <table class="table table-bordered  table-striped table-hover">
                <thead class=" text-center">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Users</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        @if(auth()->user()->hasRole('admin'))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start">{{ $task->title }}</td>
                        <td>{{ $task->project ? $task->project->title : 'No Project' }}</td>
                        <td class="text-start">
                            @if($task->project->users->isNotEmpty())
                                @foreach($task->project->users as $user)
                                    <span class="badge bg-info"> {{ $user->name }} </span>
                                @endforeach
                            @else
                                <span class="text-muted">No users assigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge 
                                {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            <select class="status-dropdown form-select form-select-sm fw-bold text-center rounded-pill border-primary shadow-sm" data-task-id="{{ $task->id }}">
                                <option value="pending" class="badge bg-secondary" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" class="badge bg-primary" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" class="badge bg-success" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->end_date }}</td>
                        @if(auth()->user()->hasRole('admin'))
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.status-dropdown').change(function(){

            let taskId = $(this).data('task-id');
            let newStatus = $(this).val();

            console.log(taskId);
            console.log(newStatus);

            $.ajax({
                url: "/tasks/" + taskId + "/update-status",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function(response){
                    console.log(response);
                    alert(response.message);
                },
                error:function(xhr){
                    alert("Error updating status");
                }
            });
        });

        $("#taskNotificationIcon").click(function () {
            $("#notificationDropdown").toggleClass("d-none");
        });

        $(document).click(function (event) {
            if (!$(event.target).closest("#taskNotificationIcon, #notificationDropdown").length) {
                $("#notificationDropdown").addClass("d-none");
            }
        });


    // Fetch Notifications
    function fetchNotifications() {
        $.ajax({
            url: "/tasks/notifications",
            type: "GET",
            success: function (response) {
                let notificationBadge = $('#taskNotificationBadge');
                let notificationList = $('#notificationList');

                notificationList.empty(); // Clear old notifications

                if (response.count > 0 && response.tasks.length > 0) {
    notificationBadge.text(response.count).removeClass('d-none');
    response.tasks.forEach(task => {
        notificationList.append(`
            <li class="p-2 border-bottom">
                <a href="/tasks/${task.id}" class="text-dark text-decoration-none d-block">
                    <strong>${task.title}</strong><br>
                    <small class="text-muted">Due: ${task.end_date}</small>
                </a>
            </li>
        `);
    });
} else {
    notificationBadge.addClass('d-none');
    notificationList.html('<li class="p-2 text-center text-muted">No new notifications</li>'); 
}

            },
            error: function () {
                console.error("Error fetching notifications");
            }
        });
    }

    fetchNotifications();
    setInterval(fetchNotifications, 60000); // Update every minute


    });
</script>

<div class="mb-3 col-md-4">
    <label for="userDropdown" class="form-label">Select Users <span class="text-danger">*</span></label>

    <div class="dropdown">
        <div class="btn btn-light form-control dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Select Users
        </div>

        <ul class="dropdown-menu w-100 p-3" aria-labelledby="userDropdown">
            @foreach($members as $member)
            <li class="form-check">
                <input class="form-check-input user-checkbox" type="checkbox" name="user_ids[]" value="{{ $member->id }}" id="user_{{ $member->id }}">
                <label class="form-check-label" for="user_{{ $member->id }}">
                    {{ $member->name }}
                </label>
            </li>
            @endforeach
        </ul>
    </div>

    <div id="selectedUsers" class="mt-2"></div>
</div>