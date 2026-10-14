@extends('layouts/contentNavbarLayout')

@include('todos.create')
@include('todos.edit')


@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between">
    <h1>My Todos</h1>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTodoModal">
      Create Todo
    </button>
  </div>

  <div class="card shadow-sm">

    <div class="card-body">
        <div class="table-responsive">

          <div class="row">
            <div class="col-md-12">
              
              <div class="flex align-content-around">
              

                <div class="input-group w-20 mb-3">
                  <select class="form-select" id="filter_priority" name="status" >
                    <option value="" disabled selected>Select Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                  </select>
                </div>
              </div>

              <div id="todos_table">
                @include('todos.todo_table')
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="mt-6 p-4">
  {{ $todos->links('vendor.pagination.bootstrap-5') }}
</div>

{{-- <script src="{{asset('assets/js/todos.js')}}"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  
  $(document).ready(function() {

    $('#filter_priority').on('change', function() {

      var priority = $(this).val();
      // alert(priority);

      $.ajax({
        url: "{{ route('todos.filter') }}",
        type: "GET",
        data: { priority : priority },

        success: function(response) {
          // console.log(response);
          $('#todos_table').html(response);
        },

        error: function(xhr) {
          console.error(xhr.responseText);
        }
      })
    })
  })

</script>

<script>

  $(document).ready(function() {

    $('.edit-todo').on('click', function() {

      var id = $(this).data('todo-id');
      var title = $(this).data('todo-title');
      var description = $(this).data('todo-description');
      var priority = $(this).data('todo-priority');
      // alert(id + title + description + priority);

      $('#editTitle').val(title);
      $('#editDescription').val(description);
      $('#editPriority').val(priority);

      $('#editTodoForm').attr('action', `/todos/${id}`);
      $('#editTodoModal').modal('show');
    })
    
  })

</script>

<!-- JavaScript to Handle Status Toggle and Edit Modal -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Status Toggle
    const checkboxes = document.querySelectorAll('.status-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function () {
        const todoId = this.getAttribute('data-todo-id');
        const title = this.closest('tr').querySelector('.todo-title');

        // Toggle strikethrough style
        title.classList.toggle('text-decoration-line-through');

        // Send AJAX request to update status
        fetch(`/todos/${todoId}/toggle-status`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ status: this.checked })
        })
        .then(response => response.json())
        .then(data => {
          console.log('Status updated:', data);
        })
        .catch(error => {
          console.error('Error updating status:', error);
        });
      });
    });
  });
</script>

@endsection