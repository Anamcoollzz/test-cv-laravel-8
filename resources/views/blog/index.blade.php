@extends('layouts.app')

@section('blog')
  active
@endsection
@section('title')
  Blog
@endsection

@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Blog</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
          <div class="breadcrumb-item">Blog</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Blog Page</h2>
        <p class="section-lead">This page is showing blog data.</p>
        <div class="card">
          <div class="card-header">
            <h4>
              Blog Data
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
                    <th>Title</th>
                    <th>Body</th>
                    <th>Image</th>
                    <th>Category</th>
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
  <script src="/plugins/summernote/dist/summernote-bs4.js"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="/plugins/summernote/dist/summernote-bs4.css">
@endpush

@push('scripts')
  <script type="text/javascript">
    $(function() {

      window.table = $('[data-toggle="datatable"]').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/blog",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'title',
            name: 'title'
          },
          {
            data: 'body',
            name: 'body'
          },
          {
            // data: 'image',
            // name: 'image'
            mRender: function(data, type, row) {
              return '<a href="' + row['image'] + '" target="_blank"><img style="max-width:150px" src="' +
                row['image'] + '" alt="' + row['title'] + '" /></a>'
            }
          },
          {
            data: 'category',
            name: 'category'
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
            axios.post('/blog/' + id, {
              _method: 'delete',
              _token: $('#csrftoken').val()
            }).then(function(response) {
              if (response.data) {
                swal('Good Job', 'Blog success deleted', 'success');
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

@include('blog.create')
@include('blog.edit')
