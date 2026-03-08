<div class="modal fade" id="EditFee" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header text-white rounded-top-4" style="background: #05738E;">
        <h5 class="modal-title">Edit Fee Item</h5>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('fees.store') }}">
          @csrf
          <div class="row">
            <div class="col-sm-6 mb-3">
              <label>Class name <strong class="text-danger">*</strong></label>
              <select class="form-control" name="class_id" required>
                <option value=""></option>
                @foreach($class as $row)
                <option value="{{ $row->name }}">{{ $row->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-6 mb-3">
              <label>Year <strong class="text-danger">*</strong></label>
              <select class="form-control" name="academic_year" required>
                <option value=""></option>
                <option value="{{ $active_year }}">{{ $active_year }}</option>
              </select>
            </div>
            <div class="col-sm-6 mb-3"><label>Amount <strong class="text-danger">*</strong></label><input type="number" name="amount" class="form-control" required></div>

            <div class="col-sm-6 mb-3">
              <label>Term <strong class="text-danger">*</strong></label>
              <select class="form-control" name="term_id" required>
                <option value=""></option>
                @foreach($active_term as $row)
                <option value="{{ $row->term_name }}">{{ $row->term_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-12 mb-3">
              <label>Description <strong class="text-danger">*</strong></label>
              <textarea class="form-control" name="maelezo" style="height:20px;" required>
                
              </textarea>
          </div>
          <div class="mt-4 d-flex justify-content-end">
            <a href="#" class="btn btn-outline-secondary rounded-pill px-4 btn-sm me-2" data-bs-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>