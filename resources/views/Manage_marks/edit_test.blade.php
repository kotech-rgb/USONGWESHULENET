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
<div class="modal fade" id="register-{{$test->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Edit Scores</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('update_test') }}">
        	@csrf
        	<input type="hidden" value="{{ $test->id}} " name="identity">
        	<input type="hidden" value="{{ $test->subjectT}}" name="subject">
        	<input type="hidden" value="{{ $test->classT}}" name="class">
        	<div class="row mb-3">
        	  <div class="col-6">
        	  	<label>Test One</label>
        	  	<input type="" class="form-control" name="test1" value="{{ $test->test1 ?? '-' }}" @if(($test->test1 ?? '-') === '-') disabled @endif>
        	  </div>

        	  <div class="col-6">
        	  	<label>Test Two</label>
        	  	<input type="" class="form-control" name="test2" value="{{ $test->test2 ?? '-' }}" @if(($test->test2 ?? '-') === '-') disabled @endif>
        	  </div>

        	  </div>


        	  <div class="row mb-3">
        	  <div class="col-6">
        	  	<label>Test Three</label>
        	  	<input type="" class="form-control" name="test3" value="{{ $test->test3 ?? '-' }}" @if(($test->test3 ?? '-') === '-') disabled @endif>
        	  </div>

        	  <div class="col-6">
        	  	<label>Test Four</label>
        	  	<input type="" class="form-control" name="test4" value="{{ $test->test4 ?? '-' }}" @if(($test->test4 ?? '-') === '-') disabled @endif>
        	  </div>

        	  </div>

        	  <div lang="row">
        	  	<div class="col-12">
        	  	<label>Test Five</label>
        	  	<input type="" class="form-control" name="test5" value="{{ $test->test4 ?? '-' }}" @if(($test->test5 ?? '-') === '-') disabled @endif>	
        	  	</div>
        	  </div>
        	  <a href="" class="btn btn-outline-secondary rounded-pill  btn-sm mt-4" data-bs-dismiss="modal">Close</a>
	          <button type="submit" class="btn btn-primary rounded-pill btn-sm mt-4"  style="float:right;">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
