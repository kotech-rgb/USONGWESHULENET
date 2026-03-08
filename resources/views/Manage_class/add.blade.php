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
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Register new</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('class_save') }}">
        	@csrf
        	<div class="row">
        	<div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Name <strong class="text-danger">*</strong></label>
        			<input type="" class="form-control" name="Class_Name" required>
        		</div>
        	  </div>

        	  <div class="col-sm-6 mb-2 col-6">
        		<div class="form-group">
        			<label>Stream <strong class="text-danger">*</strong></label>
        			<select id="select2" class="form-control" name="stream">
        				<option hidden></option>
        				<option value="A">A</option>
        				<option value="B">B</option>
        				<option value="C">C</option>
        				<option value="D">D</option>
        				<option value="E">E</option>
        				<option value="F">F</option>
        				<option value="G">G</option>
        				<option value="H">H</option>
        				<option value="I">I</option>
        				<option value="J">J</option>
        				<option value="K">K</option>
        			</select>
        		</div>
        	  </div>
        	</div>
        	  <div class="col-sm-12 mt-4">
        	  <a href="" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Close</a>
        	  <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save changes</button>	
        	  </div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
