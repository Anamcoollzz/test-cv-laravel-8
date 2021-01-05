@extends('layouts.app')

@section('expense')
  active
@endsection
@section('title')
  Expense
@endsection

@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Expense</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
          <div class="breadcrumb-item">Expense</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Expense Page</h2>
        <p class="section-lead">This page is showing expense data.</p>
        <div class="card">
          <div class="card-header">
            <h4>
              Expense Data
            </h4>
            <div class="card-header-action">
              <a href="#" data-target="#newModal" data-toggle="modal" class="btn btn-primary">New</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" data-toggle="datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Image</th>
                    <th>Buyer Name</th>
                    <th>Buyer Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection


@push('js')
  {{-- <script src="/plugins/summernote/dist/summernote-bs4.js"></script>
  --}}
@endpush

@push('css')
  {{--
  <link rel="stylesheet" href="/plugins/summernote/dist/summernote-bs4.css"> --}}
@endpush

@push('scripts')
  <script type="text/javascript">
    $(function() {

      window.table = $('[data-toggle="datatable"]').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/expense",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'product_name',
            name: 'product_name'
          },
          {
            data: 'product_price',
            name: 'product_price'
          },
          {
            data: 'qty',
            name: 'qty'
          },
          {
            data: 'price_total',
            name: 'price_total'
          },
          {
            // data: 'image',
            // name: 'image'
            mRender: function(data, type, row) {
              return '<a href="' + row['product_image'] +
                '" target="_blank"><img style="max-width:150px" src="' +
                row['product_image'] + '" alt="' + row['title'] + '" /></a>'
            }
          },
          {
            data: 'buyer_name',
            name: 'buyer_name'
          },
          {
            data: 'buyer_address',
            name: 'buyer_address'
          },
          //   {
          //     data: 'action',
          //     name: 'action',
          //     orderable: false,
          //     searchable: false
          //   },
          {
            mRender: function(data, type, row) {
              //   console.log('data', data)
              //   console.log('type', type)
              //   console.log('row', row)
              return '<a href="#" class="btn btn-sm btn-success" onclick="edit(event, ' + row['id'] +
                ')">Edit</a> ' +
                '<a href="#" class="btn btn-sm btn-danger" onclick="remove(event, ' + row['id'] +
                ')">Delete</a>'
            }
          },
        ]
      });

    });

    function remove(e, id) {
      e.preventDefault();
      swal({
          title: 'Are you sure?',
          text: 'Once deleted, you will not be able to recover this data!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.post('/expense/' + id, {
              _method: 'delete',
              _token: $('#csrftoken').val()
            }).then(function(response) {
              if (response.data) {
                swal('Good Job', 'Expense success deleted', 'success');
                table.ajax.reload();
              }
            }).catch(function(error) {
              swal({
                title: 'Error',
                text: error.response.data.message,
                icon: 'error'
              });
            }).finally(function() {});

          } else {
            swal('Okay canceled');
          }
        });

    }

  </script>
@endpush

@include('expense.create')
@include('expense.edit')
