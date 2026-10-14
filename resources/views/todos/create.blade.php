<!-- Create Todo Modal -->
<div class="modal fade" id="createTodoModal" tabindex="-1" aria-labelledby="createTodoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTodoModalLabel">Create Todo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Todo Creation Form -->
        <form id="createTodoForm" action="{{ route('todos.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter todo title" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter todo description"></textarea>
          </div>
          <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="createTodoForm" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>