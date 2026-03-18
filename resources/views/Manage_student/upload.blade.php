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

.alert ol {
    list-style-type: decimal; /* ensures numbers are shown */
    padding-left: 20px;       /* add some indentation */
}
.alert ol li {
    margin-bottom: 5px;       /* optional spacing */
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
      	<div class="col-12">
      		<!-- User description -->
              
  <div class="alert alert-warning">
  <strong>Instructions for uploading students:</strong>
  <strong>Example Excel format:</strong>
  <table class="table table-bordered mt-2 table-sm" style="table-layout: fixed;">
    <thead class="table-light text-center">
      <tr>
        <th></th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>E</th>
        <th>F</th>
        <th>G</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr>
        <th>1</th>
        <td>Firstname</td>
        <td>Middlename</td>
        <td>Lastname</td>
        <td>Gender</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Stream</td>
      </tr>
      <tr>
        <th>2</th>
        <td>John</td>
        <td>Michael</td>
        <td>Doe</td>
        <td>M</td>
        <td>Email here</td>
        <td>0712345678</td>
        <td>HGE</td>
      </tr>
      <tr>
        <th>2</th>
        <td>Mary</td>
        <td></td>
        <td>Smith</td>
        <td>F</td>
        <td>email here</td>
        <td>0723456789</td>
        <td>A</td>
      </tr>
    </tbody>
  </table>
  <ol type="A" class="mb-0">
    <li>The file must be in <strong>.xlsx, .xls, or .csv</strong> format.</li>
    <li>Include the following columns in this exact order:</li>
    <ol type="1">
      <li><strong>Firstname</strong> – Student's first name (required)</li>
      <li><strong>Middlename</strong> – Student's middle name (required)</li>
      <li><strong>Lastname</strong> – Student's last name (required)</li>
      <li><strong>Gender</strong> – M or F (required)</li>
      <li><strong>Email</strong> – Valid email address (required)</li>
      <li><strong>Phone</strong> – Contact number (required)</li>
      <li><strong>Stream</strong> – Class stream (required, e.g., HGE, HGL, etc.)</li>
    </ol>
    <li>Ensure no empty required fields and that data is clean (no extra spaces).</li>
    <li>Usiongeze column yoyote angalia mfano hapo juu Excel yako inavytakiwa  kuwa.</li>
    <li>Hakikisha Namba ya simu haianzi na alama yoyote ile</li>
    <li>Namba ya simu sio lazima ianze na 0 lakini lazima idadi ya namba zifike 10</li>
    <li>Kisha Upload File yako</li>
  </ol>

  
</div>


            </div>
 
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
