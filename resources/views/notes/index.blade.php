@extends('layouts/contentNavbarLayout')

@include('notes.create')

<style>
  .yellow { background: #ffc; }
  .green { background: #9dffb4; }
  .red { background: #fcc; }
  .note { box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.3); }
  .font_size { font-size: 1px !important; }
</style>

@section('content')
<div class="container-fluid">
  
  <div class="d-flex justify-content-between mt-4">
    <h1>Notes</h1>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createNoteModal">
      <i class="bx bx-plus"></i> Create Note
    </button>
  </div>

  <div class="card">
    <div class="card-body">
      
      {{-- <form id="deleteSelectedForm" action="{{ route('notes.destroySelected') }}" method="POST" class="mb-3"> --}}
        {{-- @csrf
        @method('POST')
        @if($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->any() as $error)
                <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
        @endif
      
        @if($notes->isEmpty())
          <input type="hidden">
        @else
          <button type="submit" id="deleteSelected" class="btn btn-danger" disabled>
            <i class="bx bx-trash"></i> Delete Selected
          </button>
        @endif --}}
      
        <div class="row mt-4">
          @if($notes->isEmpty())
            <div class="col-12 text-center text-danger" role="alert">
              No notes found. Start by creating a new note!
            </div>
          @else
            @foreach($notes as $note)
            <div class="col-md-4 mb-4">
              <div class="note {{$note->color}}">
                <div class="card-body">
                  <div class="d-flex justify-content-end font_size">
                    <span type="button" data-id="{{$note->id}}" data-title="{{$note->title}}" data-description="{{$note->description}}" data-color="{{$note->color}}" class="btn btn-primary btn-xs edit-note" target="_blank">
                      <i class="bx bx-edit"></i>
                    </span>
      
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE') 
                      <button type="submit" class="btn btn-danger btn-xs mx-1" data-bs-toggle="tooltip" data-bs-placement="left" onclick="return confirm('Are you sure you want to delete this note?')">
                        <i class="bx bx-trash"></i>
                      </button>
                    </form>
                  </div>
      
                  {{-- <div class="d-flex align-items-center">
                    <input type="checkbox" name="note_ids[]" class="ms-0 mx-2 selected-items" value="{{$note->id}}" onchange="toggleDeleteButton()">
                    <span class="note-id">#{{ $note->id }}</span>
                  </div> --}}
      
                  <h4 class="card-title mt-2">{{ $note->title }}</h4>
      
                  <p class="card-text">{{ $note->description }}</p>
      
                  <p><b class="font-weight-bold text-black-900">Created at</b> {{ $note->created_at->format('d-M-Y') }}</p>
                </div>
              </div>
            </div>
            @endforeach
          @endif
        </div>
      {{-- </form> --}}
    </div>
  </div>
</div>

<!-- JavaScript to Toggle Delete Button -->
<script>
  function toggleDeleteButton() {
    const checkboxes = document.querySelectorAll('.selected-items:checked');
    const deleteButton = document.getElementById('deleteSelected');
    deleteButton.disabled = checkboxes.length === 0;
  }
</script>

<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editNoteForm" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="editTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="editTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="editDescription" class="form-label">Description</label>
            <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="editColor" class="form-label">Color</label>
            <select class="form-select" id="editColor" name="color" required>
              <option value="green">Green</option>
              <option value="yellow">Yellow</option>
              <option value="red">Red</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/js/edit.js')}}"></script>
@endsection