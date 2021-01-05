@push('modals')

  <form action="/income" method="POST" enctype="multipart/form-data" onsubmit="store(event)" id="formNew">
    @csrf
    <div class="modal fade " tabindex="-1" role="dialog" id="newModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Income</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Product Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="product_name" id="product_name">
              <span class="invalid-feedback" id="product_nameInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Product Price <span class="text-danger">*</span></label>
              <input onkeyup="gantiTotal()" required type="number" class="form-control" name="product_price"
                id="product_price">
              <span class="invalid-feedback" id="product_priceInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Qty <span class="text-danger">*</span></label>
              <input onkeyup="gantiTotal()" required type="number" class="form-control" name="qty" id="qty">
              <span class="invalid-feedback" id="qtyInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Product Image <span class="text-danger">*</span></label>
              <input required type="file" class="form-control" name="product_image" id="product_image">
              <span class="invalid-feedback" id="product_imageInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Price Total <span class="text-danger">*</span></label>
              <input readonly required type="number" class="form-control" name="price_total" id="price_total">
              <span class="invalid-feedback" id="price_totalInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Buyer Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="buyer_name" id="buyer_name">
              <span class="invalid-feedback" id="buyer_nameInvalidFeedback"></span>
            </div>
            <div class="form-group">
              <label>Buyer Address</label>
              <textarea required class="form-control" name="buyer_address" id="buyer_address"></textarea>
              <span class="invalid-feedback" id="buyer_addressInvalidFeedback"></span>
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
      axios.post('/income', data).then(function(response) {
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
