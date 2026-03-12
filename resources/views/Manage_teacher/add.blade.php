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
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background:black;">
        <h5 class="modal-title" id="editModalLabel">Register new Staff</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('teachers_save') }}">
        	@csrf
        	<div class="row mb-2">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<input type="" class="form-control" name="fname" placeholder="Enter First Name" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<input type="" class="form-control" name="mname" placeholder="Middle Name" required>
        		</div>
        	  </div>
        	</div>

        	<div class="row mb-2">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<input type="" class="form-control" name="lname" placeholder="Last Name" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<select class="form-control" name="gender" required>
        				<option hidden selected>Gender</option>
        				<option value="M">Male</option>
        				<option value="F">Female</option>
        			</select>
        		</div>
        	  </div>
        	</div>


        	<div class="row">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<input type="" class="form-control" name="phone" placeholder="Enter Phone" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<input type="" class="form-control" name="region" placeholder="Enter Region" required>
        		</div>
        	  </div>
        	</div>

        	<div class="row">
        	<div class="col-sm-12 mb-2 col-12">
        		<div class="form-group">
        			<input type="email" class="form-control" name="email" placeholder="Email Address" required>
        		</div>
        	  </div>

        	  <div>
        		<div class="form-group">
        			<input type="hidden" class="form-control" name="password" value="1234" required>
        		</div>
        	  </div>
        	</div>

        	<div class="row">

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<select class="form-control" name="role" required>
        				<option value="">[ Select Role ]</option>
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
