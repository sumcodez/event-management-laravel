@extends('admin.layouts.app')

@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Hello {{$fullName}}!... Welcome to the dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.venues') }}">Venues</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Pie Chart -->
        <div class="col-md-6">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Pie Chart</h3>
            </div>
            <div class="card-body" style="height: 400px;">
              <canvas id="pieChart" style="width: 100%; height: 100%;"></canvas>
            </div>
          </div>
        </div>

        <!-- Stacked Bar Chart -->
        <div class="col-md-6">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Stacked Bar Chart</h3>
            </div>
            <div class="card-body" style="height: 400px;">
              <canvas id="stackedBarChart" style="width: 100%; height: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

@endsection
