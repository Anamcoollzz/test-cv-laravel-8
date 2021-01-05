@push('modals')

  <form method="POST" enctype="multipart/form-data" onsubmit="update(event)" id="formEdit">
    @csrf
    @method('put')
    <div class="modal fade " tabindex="-1" role="dialog" id="editModal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Income</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Product Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="product_name" id="product_name2">
              <span class="invalid-feedback" id="product_nameInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Product Price <span class="text-danger">*</span></label>
              <input required type="number" class="form-control" name="product_price" id="product_price2">
              <span class="invalid-feedback" id="product_priceInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Qty <span class="text-danger">*</span></label>
              <input required type="number" class="form-control" name="qty" id="qty2">
              <span class="invalid-feedback" id="qtyInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Product Image</label>
              <input type="file" class="form-control" name="product_image" id="product_image2">
              <span class="invalid-feedback" id="product_imageInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Price Total <span class="text-danger">*</span></label>
              <input readonly required type="number" class="form-control" name="price_total" id="price_total2">
              <span class="invalid-feedback" id="price_totalInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Buyer Name <span class="text-danger">*</span></label>
              <input required type="text" class="form-control" name="buyer_name" id="buyer_name2">
              <span class="invalid-feedback" id="buyer_nameInvalidFeedback2"></span>
            </div>
            <div class="form-group">
              <label>Buyer Address</label>
              <textarea required class="form-control" name="buyer_address" id="buyer_address2"></textarea>
              <span class="invalid-feedback" id="buyer_addressInvalidFeedback2"></span>
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
    var incomeId = null

    function edit(e, id) {
      e.preventDefault();
      incomeId = id;
      $('#formEdit').attr('action', 'income/' + id);
      swal({
        title: 'Info',
        text: 'Getting data....',
        button: false,
        icon: 'info'
      });
      axios.get('/income/' + id).then(function(response) {
        var income = response.data;
        $('#product_name2').val(income['product_name']);
        $('#product_price2').val(income['product_price']);
        $('#qty2').val(income['qty']);
        $('#price_total2').val(income['price_total']);
        $('#buyer_name2').val(income['buyer_name']);
        $('#buyer_address2').val(income['buyer_address']);
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
      axios.post('/income/' + incomeId, data).then(function(response) {
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
