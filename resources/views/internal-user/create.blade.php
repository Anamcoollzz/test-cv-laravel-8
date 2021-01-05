@push('modals')

  <form action="/internal-user" method="POST" enctype="multipart/form-data" onsubmit="store(event)" id="formNew">
    @csrf
    <div class="modal fade " tabindex="-1" role="dialog" id="newModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="name" id="name">
              <span class="invalid-feedback" id="nameInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Email <span class="text-danger">*</span></label>
              <input required type="email" class="form-control" name="email" id="email">
              <span class="invalid-feedback" id="emailInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Phone Number <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="phone_number" id="phone_number">
              <span class="invalid-feedback" id="phone_numberInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea required class="form-control" name="address" id="address"></textarea>
              <span class="invalid-feedback" id="addressInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Password <span class="text-danger">*</span></label>
              <input required type="password" class="form-control" name="password" id="password">
              <span class="invalid-feedback" id="passwordInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Password Confirmation <span class="text-danger">*</span></label>
              <input required type="password" class="form-control" name="password_confirmation"
                id="password_confirmation">
              <span class="invalid-feedback" id="password_confirmationInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Roles <span class="text-danger">*</span></label>
              <select required name="roles[]" class="form-control select2" multiple="" id="roles">
                @foreach ($roles as $role)
                  <option>{{ $role }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="rolesInvalidFeedback2"></span>
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
      axios.post('/internal-user', data).then(function(response) {
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

    function gantiTotal() {
      var product_price = Number($('#product_price').val());
      var qty = Number($('#qty').val());
      var price_total = product_price * qty;
      $('#price_total').val(price_total);
    }

  </script>
@endpush
