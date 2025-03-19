@extends("layouts.master_app") <!-- Extend your master layout -->

@section("title", "Booking Calendar") <!-- Sets the page title -->

@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.1/fullcalendar.min.css"
        integrity="sha256-tXJP+v7nTXzBaEuLtVup1zxWFRV2jyVemY+Ir6/CTQU=" crossorigin="anonymous" />
@endpush

@push("page_header")
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
        <h3>{{ trans("menu.calendars") }} <small>{{ trans("menu.clicktoaddediteventsBookNow") }}</small></h3>
    </div>

    <div class="x_panel">
        <!-- Search Form -->
        <form method="GET" action="{{ url("events") }}">
            <div class="x_title">
                <h2>{{ trans("menu.searchBooking") }}</h2>
                <div class="mb-3 pull-right">
                    <a href="{{ url("events") }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
                        {{ trans("menu.reset") }}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i>
                        {{ trans("menu.filter") }}</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-9 col-xs-12">
                <div class="x_content" style="margin-top: 10px">
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>{{ trans("menu.guestName") }}</label>
                        <input type="text" name="guest_name" value="{{ Request::get("guest_name", "") }}"
                            class="form-control" placeholder="Enter Guest Name">
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>{{ trans("menu.checkin_date") }}</label>
                        <input type="date" name="check_in" value="{{ Request::get("check_in", "") }}"
                            class="form-control">
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>{{ trans("menu.checkout_date") }}</label>
                        <input type="date" name="check_out" value="{{ Request::get("check_out", "") }}"
                            class="form-control">
                    </div>
                </div>
            </div>
        </form>

        @if (isset($message))
            <div class="alert alert-warning">
                {{ $message }}
            </div>
        @endif

        @if ($events->count() > 0)
        @else
            <div class="alert alert-warning">
                {{ trans("menu.noBookingsFound") }}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <p style="font-size: 18px;">{{ trans("menu.calendars") }} {{ trans("menu.bookings") }}</p>

                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#">Settings 1</a>
                                </li>
                                <li>
                                    <a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endpush

@section("content")
    <div class="container mt-3">
        <!-- Modal for Creating/Editing Bookings -->
        @include("admin.BookEvents.modals.event_create")
    </div>
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"
        integrity="sha256-C66CaAImteEKZPYvgng9j10J/45e9sAuZyfPYCwp4gE=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.1/fullcalendar.min.js"
        integrity="sha256-O04jvi1wzlLxXK6xi8spqNTjX8XuHsEOfaBRbbfUbJI=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                selectable: true,
                selectHelper: true,
                editable: true,
                header: {
                    left: 'month,agendaWeek,agendaDay,list',
                    center: 'title',
                    right: 'prev,today,next'
                },
                buttonText: {
                    today: "{{ trans('menu.today') }}",
                    month: "{{ trans('menu.month') }}",
                    week: "{{ trans('menu.week') }}",
                    day: "{{ trans('menu.day') }}",
                    list: "{{ trans('menu.list') }}"
                },
                events: [
                    @foreach ($bookings as $booking)
                        {
                            id: '{{ $booking->id }}',
                            title: '{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}',
                            start: '{{ \Carbon\Carbon::parse($booking->check_in)->toIso8601String() }}',
                            end: '{{ \Carbon\Carbon::parse($booking->check_out)->addDay()->toIso8601String() }}',
                            customer_id: '{{ $booking->customer_id }}',
                            room_id: '{{ $booking->room_id }}',
                            room_number: '{{ $booking->room->room_number }}',
                            room_floor: '{{ $booking->room->floor }}',
                            number_of_guests: '{{ $booking->number_of_guests }}',
                            total_price: '{{ $booking->total_price }}',
                            status: '{{ $booking->status }}',
                            description: '{{ $booking->description }}',
                            booking_source: '{{ $booking->booking_source }}',
                        },
                    @endforeach
                ],
    
                select: function(start, end) {
                    var minDate = moment("{{ $minDate }}", 'YYYY-MM-DD');  // Ensure $minDate is a valid date string
                    var maxDate = moment("{{ \Carbon\Carbon::parse($maxDate)->toDateString() }}", 'YYYY-MM-DD');  // Don't add a day here

                    // Check if the start date is before the minimum allowed date
                    if (start.isBefore(minDate, 'day')) {
                        iziToast.error({
                            title: 'Error',
                            message: 'The start date is outside the allowed range.',
                            position: 'topRight'
                        });
                        return false;
                    }

                    var currentTime = moment();
                    var selectedEndDate = moment(end).set({ hour: 0, minute: 0, second: 0, millisecond: 0 }); // Set time to start of day
                    if (selectedEndDate.isBefore(currentTime, 'minute') && selectedEndDate.isSame(currentTime, 'day')) {
                        iziToast.error({
                            title: 'Error',
                            message: 'The end date has already passed for today.',
                            position: 'topRight'
                        });
                        return false;
                    }


                    $('#eventForm').trigger("reset");
                    $('#eventForm').attr('data-mode', 'create');
    
                    // Automatically set check_in and check_out with the selected range
                    $('#check_in').val(moment(start).format('YYYY-MM-DD HH:mm:ss')).prop('readonly', false);
                    $('#check_out').val(moment(end).subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss')).prop('readonly', false);
    
                    // Automatically populate the other fields if needed
                    // Example: Automatically select a room or set defaults if necessary
                    // $('#room_id').val(''); // You can also set a default room ID or leave it for the user to choose.
    
                    $('#deleteEventBtn').hide();
                    $('#myModal .modal-title').text('Create Booking');
                    $('#myModal').modal('toggle');
                },
    
                eventClick: function(event) {
                    $('#eventForm').attr('data-mode', 'edit');
                    $('#eventForm').attr('data-id', event.id);
                    $('#customer_id').val(event.customer_id);
                    $('#room_id').val(event.room_id);
                    $('#check_in').val(moment(event.start).format('YYYY-MM-DD HH:mm:ss')).prop('readonly', false);
                    $('#check_out').val(moment(event.end).subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss')).prop('readonly', false);
                    $('#number_of_guests').val(event.number_of_guests);
                    $('#total_price').val(event.total_price);
                    $('#status').val(event.status);
                    $('#description').val(event.description);
                    $('#booking_source').val(event.booking_source);
                    $('#booking_reference').val(event.booking_reference);
                    $('#deleteEventBtn').show();
                    $('#myModal .modal-title').text('Edit Booking');
                    $('#myModal').modal('toggle');
                },
    
                eventDrop: function(event, delta, revertFunc) {
                    updateEvent(event);
                },
    
                eventResize: function(event, delta, revertFunc) {
                    updateEvent(event, revertFunc);
                },

                eventRender: function(event, element) {
                    console.log(event.status);

                    element.find('.fc-title').html(`
                        <span style="font-size: 12px;">${event.title}</span>
                        <span style="font-size: 12px; float: right;"> ${event.status}</span><br>
                        <span style="font-size: 12px;">Room No: ${event.room_number}</span> -
                        <span style="font-size: 12px;">Floor: ${event.room_floor}</span>
                        <span style="font-size: 12px; float: right;"> ${event.booking_source}</span>
                    `);

                    // Get current time and the checkout time
                    var currentTime = moment();
                    var checkoutTime = moment(event.end).subtract(1, 'day'); 

                    // Color-code events based on availability status
                    switch (event.status) {
                        case 'checked_in':
                            element.css('background-color', '#40c4ff'); // Light Blue for checked in
                            break;
                        case 'checked_out':
                            element.css('background-color', '#ff0000'); // Red for checked out
                            break;
                        case 'paid':
                            element.css('background-color', '#ffeb3b'); // Yellow for paid
                            break;
                        case 'confirmed':
                            element.css('background-color', '#9ccc65'); // Green for confirmed
                            break;
                        default:
                            element.css('background-color', '#bdbdbd'); // Gray for other statuses
                            break;
                    }


                    // If the current time is after the checkout time, change the color to red
                    if (currentTime.isAfter(checkoutTime, 'minute')) {
                        element.css('background-color', '#dc3545'); // Red for checkout
                    }

                    // Add tooltip with detailed info, including check-out date
                    element.tooltip({
                        title: `
                            <strong>Customer:</strong> ${event.title} <br>
                            <strong>Room No:</strong> ${event.room_number} <br>
                            <strong>Floor:</strong> ${event.room_floor} <br>
                            <strong>Check-in:</strong> ${moment(event.start).format('YYYY-MM-DD HH:mm:ss')} <br>
                            <strong>Check-out:</strong> ${moment(event.end).subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss')} <br>
                            <strong>Guests:</strong> ${event.number_of_guests} <br>
                            <strong>Status:</strong> ${event.status} <br>
                            <strong>Source:</strong> ${event.booking_source} <br>
                        `,
                        html: true,
                        placement: 'top',
                        container: 'body'
                    });
                }
            });
    
            function updateEvent(event, revertFunc) {
                var eventData = {
                    customer_id: event.customer_id,
                    room_id: event.room_id,
                    check_in: moment(event.start).format('YYYY-MM-DD HH:mm:ss'),
                    check_out: moment(event.end).subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss'),
                    number_of_guests: event.number_of_guests,
                    total_price: event.total_price,
                    status: event.status,
                    description: event.description,
                    booking_source: event.booking_source,
                    booking_reference: event.booking_reference,
                    _token: '{{ csrf_token() }}'
                };
    
                $.ajax({
                    url: '/events/' + event.id,
                    method: 'PATCH',
                    data: eventData,
                    success: function(response) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Booking updated successfully!',
                            position: 'topRight'
                        });
                        location.reload();
                    },
                    error: function() {
                        revertFunc();
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to update the booking.',
                            position: 'topRight'
                        });
                    }
                });
            }
    
            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                var mode = $(this).attr('data-mode');
                var eventData = {
                    customer_id: $('#customer_id').val(),
                    room_id: $('#room_id').val(),
                    check_in: $('#check_in').val(),
                    check_out: $('#check_out').val(),
                    number_of_guests: $('#number_of_guests').val(),
                    total_price: $('#total_price').val(),
                    status: $('#status').val(),
                    description: $('#description').val(),
                    booking_source: $('#booking_source').val(),
                    booking_reference: $('#booking_reference').val(),
                    _token: '{{ csrf_token() }}'
                };
    
                var url = mode === 'create' ? '{{ route("event_calendar.store") }}' :
                    '/event_calendar/update/' + $('#eventForm').attr('data-id');
                var method = mode === 'create' ? 'POST' : 'PATCH';
    
                $.ajax({
                    url: url,
                    method: method,
                    data: eventData,
                    success: function(response) {
                        calendar.fullCalendar('refetchEvents');
                        $('#myModal').modal('toggle');
                        iziToast.success({
                            title: 'Success',
                            message: 'Booking ' + (mode === 'create' ? 'created' : 'updated') + ' successfully!',
                            position: 'topRight'
                        });
                        location.reload();
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'An error occurred.',
                            position: 'topRight'
                        });
                    }
                });
            });
    
            $('#deleteEventBtn').on('click', function() {
                var eventId = $('#eventForm').attr('data-id');
                $.ajax({
                    url: '/event_calendar/destroy/' + eventId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        calendar.fullCalendar('removeEvents', eventId);
                        $('#myModal').modal('toggle');
                        iziToast.success({
                            title: 'Success',
                            message: 'Booking deleted successfully!',
                            position: 'topRight'
                        });
                        location.reload();
                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to delete the booking.',
                            position: 'topRight'
                        });
                    }
                });
            });
        });
    </script>
@endpush
