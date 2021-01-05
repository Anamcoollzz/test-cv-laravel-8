@push('modals')

  <form method="POST" enctype="multipart/form-data" onsubmit="update(event)" id="formEdit">
    @csrf
    @method('put')
    <div class="modal fade " tabindex="-1" role="dialog" id="editModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="name" id="name2">
              <span class="invalid-feedback" id="nameInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Email <span class="text-danger">*</span></label>
              <input required type="email" class="form-control" name="email" id="email2">
              <span class="invalid-feedback" id="emailInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Phone Number <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="phone_number" id="phone_number2">
              <span class="invalid-feedback" id="phone_numberInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea required class="form-control" name="address" id="address2"></textarea>
              <span class="invalid-feedback" id="addressInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" id="password2">
              <span class="invalid-feedback" id="passwordInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Password Confirmation</label>
              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation2">
              <span class="invalid-feedback" id="password_confirmationInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Roles <span class="text-danger">*</span></label>
              <select id="roles2" required name="roles[]" class="form-control select2" multiple="">
                @foreach ($roles as $role)
                  <option>{{ $role }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="rolesInvalidFeedback2"></span>
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
    var userId = null

    function edit(e, id) {
      e.preventDefault();
      userId = id;
      $('#formEdit').attr('action', 'internal-user/' + id);
      swal({
        title: 'Info',
        text: 'Getting data....',
        button: false,
        icon: 'info'
      });
      axios.get('/internal-user/' + id).then(function(response) {
        var user = response.data;
        $('#name2').val(user['name']);
        $('#email2').val(user['email']);
        $('#address2').val(user['address']);
        $('#phone_number2').val(user['phone_number']);
        var roles = user['roles'].map(function(item) {
          return item.name;
        });
        // console.log('roles', roles);
        $('#roles2').val(roles);
        $('#roles2').trigger('change');

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
      axios.post('/internal-user/' + userId, data).then(function(response) {
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
