@push('modals')

  <form method="POST" enctype="multipart/form-data" onsubmit="update(event)" id="formEdit">
    @csrf
    @method('put')
    <div class="modal fade " tabindex="-1" role="dialog" id="editModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Blog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Title <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="title" id="title2">
              <span class="invalid-feedback" id="titleInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Body <span class="text-danger">*</span></label>
              <textarea id="body2" required class="summernote" name="body"></textarea>
              <span class="text-danger" id="bodyInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Image</label>
              <input type="file" class="form-control" name="image" id="image2">
              <span class="invalid-feedback" id="imageInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Category <span class="text-danger">*</span></label>
              <select required name="category" id="category2" class="form-control">
                @foreach (range(1, 10) as $i)
                  <option value="Category {{ $i }}">Category {{ $i }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="categoryInvalidFeedback2"></span>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="buttonSave2">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  </form>

@endpush

@push('scripts')
  <script>
    var blogId = null

    function edit(e, id) {
      e.preventDefault();
      blogId = id;
      $('#formEdit').attr('action', 'blog/' + id);
      swal({
        title: 'Info',
        text: 'Getting data....',
        button: false,
        icon: 'info'
      });
      axios.get('/blog/' + id).then(function(response) {
        var blog = response.data;
        $('#title2').val(blog['title']);
        $("#body2").summernote("code", blog['body']);
        $('#category2').val(blog['category']);
        $('#editModal').modal('show');
        swal.close();
      }).catch(function(error) {
        swal({
          title: 'Error',
          text: error.response.data.message,
          icon: 'error'
        });
      }).finally(function() {});

    }

    function update(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');
      $('.invalid-feedback').empty();
      $('#buttonSave2').html('Saving...');
      $('#buttonSave2').attr('disabled', true);
      swal({
        title: 'Info',
        text: 'Processing....',
        button: false,
        icon: 'info'
      });
      var data = new FormData(document.getElementById('formEdit'));
      axios.post('/blog/' + blogId, data).then(function(response) {
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
            $('#' + keys[i] + '2').addClass('is-invalid');
            $('#' + keys[i] + 'InvalidFeedback2').html(errors[keys[i]][0]);
          }
        }
      }).finally(function() {
        $('#buttonSave2').html('Save changes');
        $('#buttonSave2').attr('disabled', false);
      });
    }

  </script>
@endpush
