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
<div class="modal fade" id="{{$confirm_del}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4 bg-danger">
        <h5 class="modal-title" id="editModalLabel">Confirm Delete Student</h5>
      </div>
      <div class="modal-body p-4">

       <form action="{{ route('student_delete_confirm') }}" method="POST">
       	@csrf
       	<input type="hidden" value="{{ $row->id }}" name="student_id">
        @csrf
        <p>Choose action to : {{ $row->firstname.' '.$row->middlename.' '.$row->lastname }} of {{ $row->class_name }}</p><br>
        <select class="form-control" name="action" required>
        	<option value="" selected hidden></option>
        	<option value="confirmed">Delete this student parmanently</option>
        	<option value="canceled">Cancel delete operation</option>
        </select>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Submit request</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
