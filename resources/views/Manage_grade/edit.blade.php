<style>
	.modal-content {
	  transition: transform 0.3s ease-out;
	}
	.modal.fade .modal-dialog {
	  transform: translateY(-30px);
	}
	.modal.fade.show .modal-dialog {
	  transform: translateY(0);
	}
</style>

<!-- Modal -->
<div class="modal fade" id="edit-{{$row->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Edit Grade</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('grade.update') }}">
          @csrf
          @method('POST')
          <div class="row">
          <input type="hidden" value="{{ $row->id }}" name="grade_id">  
          <div class="mb-3 col-6">
            <label for="edit-grade-name" class="form-label">Grade Name <strong class="text-danger">*</strong></label>
            <input type="text" class="form-control" name="grade_name" value="{{ $row->name }}" required>
          </div>

          <div class="mb-3 col-6">
            <label for="edit-grade-end" class="form-label">Points <strong class="text-danger">*</strong></label>
            <input type="text" class="form-control" name="points" value="{{ $row->points }}" required>
          </div>

          <div class="mb-3 col-6">
            <label for="edit-grade-start" class="form-label">Start Score <strong class="text-danger">*</strong></label>
            <input type="number" class="form-control" name="start_score" value="{{ $row->start_form}}" required>
          </div>

          <div class="mb-3 col-6">
            <label for="edit-grade-end" class="form-label">End Score <strong class="text-danger">*</strong></label>
            <input type="number" class="form-control" name="end_score" value="{{ $row->end_to }}" required>
          </div>

          <div class="text-end">
            <a href="#" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
