<table class="table table-bordered">
  <thead>
    <tr>
      <th>Status</th>
      <th>Title</th>
      <th>Description</th>
      <th>Priority</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @if($todos->isEmpty())
        <tr>
            <td colspan="6" class="text-center text-danger" role="alert">
                No todos found
            </td>
        </tr>
    @else
        @foreach($todos as $todo)
        <tr>
            <td>
                <input type="checkbox" class="status-checkbox" data-todo-id="{{ $todo->id }}" {{ $todo->status ? 'checked' : '' }}>
            </td>
            <td>
                <span class="todo-title {{ $todo->status ? 'text-decoration-line-through' : '' }}">
                    {{ $todo->title }}
                </span>
            </td>
            <td>{{ $todo->description }}</td>
            <td>
                <span class="badge bg-{{ $todo->priority === 'high' ? 'danger' : ($todo->priority === 'medium' ? 'warning' : 'success') }}">
                    {{ ucfirst($todo->priority) }}
                </span>
            </td>
            <td>{{ $todo->created_at->format('Y-m-d H:i:s') }}</td>
            <td>
                <button type="button" class="btn btn-warning btn-sm edit-todo"
                        data-bs-toggle="modal" data-bs-target="#editTodoModal"
                        data-todo-id="{{ $todo->id }}"
                        data-todo-title="{{ $todo->title }}"
                        data-todo-description="{{ $todo->description }}"
                        data-todo-priority="{{ $todo->priority }}">
                        <i class="bx bx-edit"></i> Edit
                </button>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-2 btn-sm" onclick="return confirm('Are you sure you want to delete this todo?')"><i class="bx bx-trash"></i> Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    @endif
  </tbody>
</table>
