@extends('layouts.app')

@section('public-user')
  active
@endsection
@section('title')
  Public User
@endsection

@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Public User</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
          <div class="breadcrumb-item">Public User</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Public User Page</h2>
        <p class="section-lead">This page is showing public user data.</p>
        <div class="card">
          <div class="card-header">
            <h4>
              Public User Data
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Verified At</th>
                    {{-- <th>Profile Picture</th> --}}
                    <th>Address</th>
                    <th>Phone Number</th>
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
        ajax: "/public-user",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'email_verified_at',
            name: 'email_verified_at'
          },
          //   {
          //     mRender: function(data, type, row) {
          //       if (row['profile_picture'] === '/')
          //         return null
          //       return '<a href="' + row['profile_picture'] +
          //         '" target="_blank"><img style="max-width:150px" src="' +
          //         row['profile_picture'] + '" alt="' + row['name'] + '" /></a>'
          //     }
          //   },
          {
            data: 'address',
            name: 'address'
          },
          {
            data: 'phone_number',
            name: 'phone_number'
          },
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
            axios.post('/public-user/' + id, {
              _method: 'delete',
              _token: $('#csrftoken').val()
            }).then(function(response) {
              if (response.data) {
                swal('Good Job', 'Public User success deleted', 'success');
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

@include('public-user.create')
@include('public-user.edit')
