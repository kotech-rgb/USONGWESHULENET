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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title" id="editModalLabel">Register new</h5>
      </div>
      <div class="modal-body p-4">
       <form action="{{ route('student_save') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name" required>
            </div>

            <div class="col-md-6">
              <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Enter Middle Name" required>
            </div>

            <div class="col-md-6">
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name" required>
            </div>

            <div class="col-md-6">
              <select name="gender" id="gender" class="form-select" required>
                <option value="" selected disabled>Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
            </div>

            <div class="col-md-6">
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
            </div>

            <div class="col-md-6">
              <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone" required>
            </div>

            <div class="col-md-6">
              <select name="class_name" class="form-control select2" required>
                <!-- <option value="" selected disabled>Select Class</option> -->
                @foreach($classes as $class)
                  <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save changes</button>
        </div>
      </form>


      </div>
    </div>
  </div>
</div>
