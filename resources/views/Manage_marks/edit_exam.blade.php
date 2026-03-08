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
<div class="modal fade" id="register-{{$student->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Edit Scores</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('update_exam') }}">
        	@csrf
        	<input type="hidden" value="{{ $student->id}} " name="identity">
        	<div class="row mb-3">
        	  <div class="col-8">
        	  	<label>Examination Score</label>
        	  	<input type="" class="form-control" name="score" value="{{ $student->score ?? '-' }}" @if(($student->score ?? '-') === '-') disabled @endif>
        	  </div>

        	  </div>
        	  <a href="" class="btn btn-outline-secondary rounded-pill  btn-sm mt-4" data-bs-dismiss="modal">Close</a>
	          <button type="submit" class="btn btn-primary rounded-pill btn-sm mt-4"  style="float:right;">Save changes</button>
        	
        </form>
      </div>
    </div>
  </div>
</div>
