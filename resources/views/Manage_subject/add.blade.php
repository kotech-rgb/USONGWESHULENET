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
       <form action="{{ route('subjects_save') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-12">
              <input type="text" name="sub_name" class="form-control" placeholder="Enter Subject name" required>
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
