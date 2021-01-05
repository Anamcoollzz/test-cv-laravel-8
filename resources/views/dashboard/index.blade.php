@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('dashboard')
  active
@endsection

@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Dashboard</h1>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total User</h4>
              </div>
              <div class="card-body">
                {{ number_format($totalUser, 0, ',', '.') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success text-white">
              <i class="fas fa-money-check-alt"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Income</h4>
              </div>
              <div class="card-body">
                {{ number_format($totalIncome, 0, ',', '.') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger text-white">
              <i class="fas fa-money-check"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Expense</h4>
              </div>
              <div class="card-body">
                {{ number_format($totalExpense, 0, ',', '.') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info text-white">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Nett Profit</h4>
              </div>
              <div class="card-body">
                {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Income vs Expense</h4>
            </div>
            <div class="card-body">
              <canvas id="myChart" height="158"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Activty Log</h4>
            </div>
            <div class="card-body">
              <table data-toggle="datatable" class="table table-bordered table-striped table-hovered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Activity</th>
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
  <script src="/plugins/chart.js/dist/Chart.min.js"></script>
@endpush

@push('scripts')
  <script>
    $(function() {

      window.table = $('[data-toggle="datatable"]').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/dashboard",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            mRender: function(data, type, row) {
              return row['causer']['name']
            }
          },
          {
            data: 'description',
            name: 'description'
          },
        ]
      });

    });

    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
          "November",
          "Desember"
        ],
        datasets: [{
            label: 'Expense',
            data: @json($expenseInYear),
            borderWidth: 2,
            backgroundColor: '#6777ef',
            borderColor: '#6777ef',
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointRadius: 4
          },
          {
            label: 'Income',
            data: @json($incomeInYear),
            borderWidth: 2,
            backgroundColor: '#ff0000',
            borderColor: '#ff0000',
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointRadius: 4
          }
        ]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false,
              color: '#f2f2f2',
            },
            ticks: {
              beginAtZero: true,
              stepSize: 150
            }
          }],
          xAxes: [{
            ticks: {
              display: false
            },
            gridLines: {
              display: false
            }
          }]
        },
      }
    });

  </script>
@endpush
