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
<div class="modal fade" id="upload" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Upload students</h5>
      </div>
      <div class="modal-body p-4">
       <form action="{{ route('students.upload') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
	    <div class="col-4">
	        <label>Select class <strong class="text-danger">*</strong></label>
	        <select name="class_name" class="form-select select2" required>
	        	<option hidden selected></option>
	          <option value="FORM ONE">FORM ONE</option>
	          <option value="FORM TWO">FORM TWO</option>  
	          <option value="FORM THREE">FORM THREE</option>  
	          <option value="FORM FOUR">FORM FOUR</option>  
	          <option value="FORM FIVE">FORM FIVE</option>  
	          <option value="FORM SIX">FORM SIX</option>    
	        </select>
	    </div>

	    <div class="col-4">
	        <input type="file" class="form-control mt-4" name="file" accept=".xlsx,.xls,.csv" required>
	    </div>
	    <div class="col-4">
	    <button type="submit" class="btn btn-success btn-sm  mt-4">Click to upload <i class="fa fa-arrow-circle-right"></i></button>
	    <a href="" class="btn btn-outline-danger rounded-pill btn-sm mt-4" data-bs-dismiss="modal">Close <i class="fa fa-times"></i></a>
	    <div>
	    </div>
	</form>
      </div>
    </div>
  </div>
</div>
