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
        <form action="{{ route('student_update', $row->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="modal-body">
          <div class="row g-3">
            
            <div class="col-md-6">
              <label class="form-label">Index Number</label>
              <input type="number" name="index_number" value="{{ str_pad($row->index_number, 4, '0', STR_PAD_LEFT) }}" class="form-control bg-light" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label">First Name</label>
              <input type="text" name="firstname" value="{{ $row->firstname }}" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Middle Name</label>
              <input type="text" name="middlename" value="{{ $row->middlename }}" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="lastname" value="{{ $row->lastname }}" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select" required>
                <option value="M" {{ $row->gender == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ $row->gender == 'F' ? 'selected' : '' }}>Female</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ $row->email }}" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" value="{{ $row->phone }}" class="form-control" required>
            </div>
          </div>
          <label style="font-size: 11px; color: orange; margin-top: 2vh;">After change this class student will be affected</label>
           <select class="form-control select2" name="class_name">
                <option selected>{{ $row->class_name }}</option>
                @foreach($classes as $row)
                <option value="{{ $row->name }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill btn-sm">Save changes</button>
        </div>
      </form>


      </div>
    </div>
  </div>
</div>
