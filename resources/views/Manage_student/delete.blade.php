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
<div class="modal fade" id="{{$modalDel}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4 bg-danger">
        <h5 class="modal-title" id="editModalLabel">Delete Student</h5>
      </div>
      <div class="modal-body p-4">

       <form action="{{ route('students.delete_request') }}" method="POST">
       	<input type="hidden" value="{{ $row->id }}" name="student_id">
        @csrf
        <p>Are you sure you want to request delete of student named: {{ $row->firstname.' '.$row->middlename.' '.$row->lastname }} of {{ $row->class_name }} ?</p><br>
        <label>Write reasons <strong class="text-danger">*</strong></label>
        <input type="hidden" name="request_type" value="delete">
        <input type="hidden" name="staff_id">
      <input type="hidden" value="{{ Auth()->user()->fname }} {{ Auth()->user()->mname }} {{ Auth()->user()->lname }}"
       name="requested_by">
        <textarea style="width:100%;" name="reason" required>
        </textarea>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Submit request</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
