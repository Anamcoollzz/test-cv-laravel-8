@push('modals')

  <form action="/blog" method="POST" enctype="multipart/form-data" onsubmit="store(event)" id="formNew">
    @csrf
    <div class="modal fade " tabindex="-1" role="dialog" id="newModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Blog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Title <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="title" id="title">
              <span class="invalid-feedback" id="titleInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Body <span class="text-danger">*</span></label>
              <textarea required class="summernote" name="body"></textarea>
              <span class="text-danger" id="bodyInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Image <span class="text-danger">*</span></label>
              <input required type="file" class="form-control" name="image" id="image">
              <span class="invalid-feedback" id="imageInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Category <span class="text-danger">*</span></label>
              <select required name="category" id="category" class="form-control">
                @foreach (range(1, 10) as $i)
                  <option value="Category {{ $i }}">Category {{ $i }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="categoryInvalidFeedback"></span>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="buttonSave">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  </form>

@endpush

@push('scripts')
  <script>
    function store(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');
      $('.invalid-feedback').empty();
      $('#buttonSave').html('Saving...');
      $('#buttonSave').attr('disabled', true);
      swal({
        title: 'Info',
        text: 'Processing....',
        button: false,
        icon: 'info'
      });
      var data = new FormData(document.getElementById('formNew'));
      axios.post('/blog', data).then(function(response) {
        swal('Good Job', response.data.message, 'success');
        window.table.ajax.reload();
      }).catch(function(error) {
        swal({
          title: 'Error',
          text: error.response.data.message,
          icon: 'error'
        });
        var errors = error.response.data.errors;
        if (error.response.status === 422) {
          var keys = Object.keys(errors);
          for (var i = 0; i < keys.length; i++) {
            $('#' + keys[i]).addClass('is-invalid');
            $('#' + keys[i] + 'InvalidFeedback').html(errors[keys[i]][0]);
          }
        }
      }).finally(function() {
        $('#buttonSave').html('Save changes');
        $('#buttonSave').attr('disabled', false);
      });
    }

  </script>
@endpush
