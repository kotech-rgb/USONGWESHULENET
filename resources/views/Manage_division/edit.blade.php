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
        <h5 class="modal-title" id="editModalLabel">Edit Division</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('divisions.update') }}">
          @csrf
          @method('POST')
          <div class="mb-6">
            <input type="hidden" value="{{ $row->id }}" name="div_id">
            <label for="edit-grade-name" class="form-label">Grade Name <strong class="text-danger">*</strong></label>
            <input type="text" class="form-control" name="div_name" value="{{ $row->div_name }}" required>
          </div>

          <div class="mb-3">
            <label for="edit-grade-start" class="form-label">Start Point <strong class="text-danger">*</strong></label>
            <input type="number" class="form-control" name="start_point" value="{{ $row->start_point }}" required>
          </div>

          <div class="mb-3">
            <label for="edit-grade-end" class="form-label">End Point <strong class="text-danger">*</strong></label>
            <input type="number" class="form-control" name="end_point" value="{{ $row->end_point }}" required>
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
