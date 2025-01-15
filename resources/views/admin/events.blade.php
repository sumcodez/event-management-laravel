@extends('admin.layouts.app')

@section('content')


{{-- Update Modal --}}
@foreach ($events as $event)
<div class="modal fade" id="editModal-{{ $event->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="event_title_{{ $event->id }}">Event Title</label>
                        <input type="text" name="title" id="event_title_{{ $event->id }}" class="form-control" value="{{ $event->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="event_description_{{ $event->id }}">Event Description</label>
                        <textarea name="description" id="event_description_{{ $event->id }}" class="form-control" required>{{ $event->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="event_date_{{ $event->id }}">Event Date</label>
                        <input type="date" name="date" id="event_date_updated" class="form-control" value="{{ $event->date }}" required>
                        <small id="date-error_update" class="text-danger" style="display: none;">The event date cannot be in the past.</small>
                    </div>
                    <div class="form-group">
                        <label for="event_time_{{ $event->id }}">Event Time</label>
                        <input type="time" name="time" id="event_time" class="form-control" value="{{ $event->time }}" required>
                        <small id="title-error" class="text-danger" style="display: none;">This title already exists for the selected date and venue.</small>
                    </div>
                    <div class="form-group">
                        <label for="venue_{{ $event->id }}">Venue</label>
                        <select name="venue_id" id="venue_{{ $event->id }}" class="form-control" required>
                            <option value="" disabled>Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ $event->venue_id == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }}
                                </option>
                            @endforeach
                        </select>
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
                <h4 class="modal-title">Add Event Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('events.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="event_title">Event Title</label>
                        <input type="text" name="title" id="event_title" class="form-control" placeholder="Enter event title" required>
                        <small id="title-error" class="text-danger" style="display: none;">This title already exists for the selected date and venue.</small>
                    </div>
                    <div class="form-group">
                        <label for="event_description">Event Description</label>
                        <textarea name="description" id="event_description" class="form-control" placeholder="Enter event description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="event_date">Event Date</label>
                        <input type="date" name="date" id="event_date" class="form-control" required>
                        <small id="date-error" class="text-danger" style="display: none;">The event date cannot be in the past.</small>
                    </div>
                    <div class="form-group">
                        <label for="event_time">Event Time</label>
                        <input type="time" name="time" id="event_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue</label>
                        <select name="venue_id" id="venue" class="form-control" required>
                            <option value="" disabled selected>Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                        <h3 class="card-title">List of All Events</h3>
                        <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-success btn-sm float-right">
                            Add Event
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Table for showing the data -->
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Event Title</th>
                                    <th>Event Description</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>Venue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->description }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ $event->time }}</td>
                                    <td>
                                    @php
                                        $venue = $venues->firstWhere('id', $event->venue_id); // Find the venue by ID
                                    @endphp
                                        {{ $venue ? $venue->name : 'Venue Not Found' }} <!-- Display venue name or 'Not Found' if no match -->
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-dark">Action</button>
                                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal-{{ $event->id }}">Edit</a>
                                                <a class="dropdown-item" href="{{ route('events.delete', $event->id) }}" onclick="return confirm('Are you sure you want to delete this venue?')">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
    const eventDateInput = document.getElementById('event_date');
    const dateError = document.getElementById('date-error');
    const eventDateInputUpdated = document.querySelectorAll('.event-date-input');
    const dateErrorUpdated = document.querySelectorAll('.date-error-updated');
    const eventForms = document.querySelectorAll('form'); // Select all forms

    // Function to handle date validation
    function validateEventDate(input, errorElement) {
        const selectedDate = new Date(input.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Remove time part

        if (selectedDate < today) {
            errorElement.style.display = 'block';
            input.classList.add('is-invalid');
            input.value = ''; // Clear input if invalid
        } else {
            errorElement.style.display = 'none';
            input.classList.remove('is-invalid');
        }
    }

    // Validate date for create modal
    eventDateInput.addEventListener('change', function () {
        validateEventDate(eventDateInput, dateError);
    });

    // Validate date for edit modals
    eventDateInputUpdated.forEach(input => {
        input.addEventListener('change', function () {
            const errorElement = input.closest('.modal').querySelector('.date-error-updated');
            validateEventDate(input, errorElement);
        });
    });

    // Prevent form submission if the date is in the past
    eventForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            const eventDateInputs = form.querySelectorAll('input[type="date"]');
            let isValid = true;

            eventDateInputs.forEach(input => {
                const errorElement = input.closest('.modal').querySelector('.date-error-updated') || dateError;
                if (new Date(input.value) < new Date()) {
                    event.preventDefault();
                    errorElement.style.display = 'block';
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if any date is invalid
            }
        });
    });

    // Example logic for title uniqueness (needs backend validation)
    const titleInputs = document.querySelectorAll('#event_title, #event_title_{{ $event->id }}');
    const titleError = document.querySelectorAll('.title-error');

    titleInputs.forEach((titleInput, index) => {
        titleInput.addEventListener('blur', function () {
            const errorElement = titleError[index];
            fetch('/api/check-event-title', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    title: titleInput.value,
                    date: form.querySelector('input[type="date"]').value,
                    venue: form.querySelector('select[name="venue_id"]').value,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.isUnique) {
                    errorElement.style.display = 'block';
                    titleInput.classList.add('is-invalid');
                } else {
                    errorElement.style.display = 'none';
                    titleInput.classList.remove('is-invalid');
                }
            });
        });
    });
});



</script>


@endsection
