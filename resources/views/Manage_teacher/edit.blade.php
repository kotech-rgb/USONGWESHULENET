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
<div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('teachers_edit') }}">
        	@csrf
        	<input type="hidden" name="id" value="{{ $row->id }}">
        	<div class="row">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>First Name</label>
        			<input type="" class="form-control" name="fname" value="{{ $row->fname }}">
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Middle Name</label>
        			<input type="" class="form-control" name="mname" value="{{ $row->mname }}" required>
        		</div>
        	  </div>
        	</div>

        	<div class="row">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Last Name</label>
        			<input type="" class="form-control" name="lname" value="{{ $row->lname }}" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Gender</label>
        			<select class="form-control" name="gender">
        				<option hidden>{{ $row->gender }}</option>
        				<option value="M">ME</option>
        				<option value="F">KE</option>
        			</select>
        		</div>
        	  </div>
        	</div>

        	<div class="row">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Phone</label>
        			<input type="" class="form-control" name="phone" value="{{ $row->phone }}" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Region</label>
        			<input type="" class="form-control" name="region" value="{{ $row->region }}" required>
        		</div>
        	  </div>
        	</div>

        	<div class="row">

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Role</label>
        			<select class="form-control" name="role">
        				<option hidden>{{ $row->role }}</option>
        				<option value="Teacher">Teacher</option>
        				<option value="Academic">Academic</option>
        				<option value="Headmaster">Headmaster</option>
        				<option value="Account">Account</option>
        			</select>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mt-4">
        	  <a href="" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Close</a>
        	  <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save changes</button>	
        	  </div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
