<!-- create Note Modal -->
<div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createNoteModalLabel">Create Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createNoteForm" action="{{ route('notes.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="createTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="createTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="createDescription" class="form-label">Description</label>
            <textarea class="form-control" id="createDescription" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="createColor" class="form-label">Color</label>
            <select class="form-select" id="createColor" name="color" required>
              <option value="green">Green</option>
              <option value="yellow">Yellow</option>
              <option value="red">Red</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Craete Note</button>
        </form>
      </div>
    </div>
  </div>
</div>