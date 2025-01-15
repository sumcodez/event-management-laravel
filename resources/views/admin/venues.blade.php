@extends('admin.layouts.app')

@section('content')

{{-- Update Modal --}}
@foreach ($venues as $venue)
<div class="modal fade" id="editModal-{{ $venue->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Venue</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="venue_name_{{ $venue->id }}">Venue Name</label>
                        <input type="text" name="name" id="venue_name_{{ $venue->id }}" class="form-control" value="{{ $venue->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="venue_location_{{ $venue->id }}">Venue Location</label>
                        <input type="text" name="location" id="venue_location_{{ $venue->id }}" class="form-control" value="{{ $venue->location }}" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity_{{ $venue->id }}">Capacity</label>
                        <input type="number" name="capacity" id="capacity_{{ $venue->id }}" class="form-control" value="{{ $venue->capacity }}" min="1" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach



{{-- Create Modal --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Venue Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('venues.create') }}" method="POST">
            @csrf
            <div class="modal-body">
                <p>Fill the venue details&hellip;</p>
                <div class="form-group">
                    <label for="venue_name">Venue Name</label>
                    <input type="text" name="name" id="venue_name" class="form-control" placeholder="Enter venue name" required>
                </div>
                <div class="form-group">
                    <label for="venue_name">Venue Location</label>
                    <input type="text" name="location" id="venue_location" class="form-control" placeholder="Enter venue name" required>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" placeholder="Enter capacity" min="1" required>
                    <small id="capacity-error" class="text-danger" style="display: none;">Capacity must be at least 1.</small>
                </div>        
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Dashboard</h1>
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of All Venues</h3>
                            <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-success btn-sm float-right">
                                Add Venue
                            </a>
                        </div>

                        <div class="card-body">

                          <!-- Table for showing the data -->
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Venue Name</th>
                                        <th>Venue Location</th>
                                        <th>Capacity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($venues->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No venues found.</td>
                                        </tr>
                                    @else
                                    @foreach ($venues as $venue)
                                    <tr>
                                        <td>{{ $venue->name }}</td>
                                        <td>{{ $venue->location }}</td>
                                        <td>{{ $venue->capacity }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-dark">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal-{{ $venue->id }}">Edit</a>
                                                    <a class="dropdown-item" href="{{ route('venues.delete', $venue->id) }}" onclick="return confirm('Are you sure you want to delete this venue?')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const capacityInput = document.getElementById('capacity');
            const capacityError = document.getElementById('capacity-error');
    
            capacityInput.addEventListener('input', function () {
                if (capacityInput.value < 1) {
                    capacityError.style.display = 'block';
                    capacityInput.classList.add('is-invalid');
                } else {
                    capacityError.style.display = 'none';
                    capacityInput.classList.remove('is-invalid');
                }
            });
        });
    </script>

@endsection
