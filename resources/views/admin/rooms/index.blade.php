@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
            font-size: 12px;
        }

        .icon-item {
            color: rgb(145, 89, 89)
        }

        .icon-ite {
            color: red
        }

        /* Ensure the heading is always visible */
        .print-header {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #405467;
            /* Match table color */
            display: block;
        }

        /* PRINT STYLING */
        @media print {

            /* Hide everything except the header and table */
            body * {
                visibility: hidden;
            }

            /* Following tables: Each table on a new page */
            .print-table-container:nth-child(n+2) {
                page-break-before: always;
            }

            .print-header,
            #printable-table,
            #printable-table * {
                visibility: visible;
            }

            /* Ensure table visibility */
            #printable-table {
                position: static;
                width: 100%;
                page-break-before: always;
                border: 1px solid #000;
            }

            /* Table header */
            #printable-table thead th {
                background-color: #405467 !important;
                color: #ffffff !important;
                font-weight: bold;
                text-align: center;
            }

            /* Table rows */
            #printable-table tbody tr {
                background-color: #ffffff !important;
                color: #000 !important;
            }

            /* Striped rows */
            #printable-table tbody tr:nth-child(even) {
                background-color: #d3d9e0 !important;
            }

            /* Table borders */
            #printable-table th,
            #printable-table td {
                border: 1px solid #405467 !important;
                padding: 8px;
            }

            /* Hide unnecessary elements */
            .btn,
            .no-print {
                display: none !important;
            }
        }
        .status-available {
            background-color: #ffc107; /* Green color */
            color: white;
        }

        .status-booked {
            background-color: #22c55e; /* Gray color */
            color: white;
        }

        .status-maintenance {
            background-color: #28a745; /* Yellow color */
            color: white;
        }

        .status-cleaning {
            background-color: #17a2b8; /* Light blue color */
            color: white;
        }
    </style>
@endpush
@section("content")
    <div class="col-md-12">
        <div class="pull-right">
            <div class="close-link">
                @if (session("status"))
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true,
                        })
                        Toast.fire({
                            icon: 'success',
                            title: "{{ session("status") }}",
                        })
                    </script>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ trans("menu.roomList") }}</h3>
        </div>
        <!--- ========== ./ This Filter Code Room ============ -->

        <div class="x_panel">
            <form method="GET" action="{{ url("rooms") }}">
                <div class="x_title">
                    <h2>{{ trans("menu.serarchTableRoom") }}</h2>
                    <div class="mb-3 pull-right">
                        <a href="{{ url("rooms") }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
                            {{ trans("menu.reset") }}</a>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i>
                            {{ trans("menu.filter") }}</button>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12 col-sm-9 col-xs-12">
                    <div class="x_content" style="margin-top: 10px">
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.roomName") }}</label>
                            <input type="text" name="name" value="{{ Request::get("name") }}" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.bedRoom") }}</label>
                            <select name="room_type_id" class="form-control">
                                <option value="">----{{ trans("menu.selectbedType") }}----</option>
                                @foreach ($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}"
                                        {{ Request::get("room_type_id") == $roomType->id ? "selected" : "" }}>
                                        {{ $roomType->name }} {{ $roomType->room_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.codeRoom") }}</label>
                            <input type="text" name="code" value="{{ Request::get("code") }}" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.floor") }}</label>
                            <input type="text" name="floor" value="{{ Request::get("floor") }}" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="x_panel">
            <!--- ./ Title navdar --->

            <div class="x_title">
                <div class="mb-3 pull-right">
                    @can('Create Room')
                        <a href="{{ url("rooms/create") }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            {{ trans("menu.addRoom") }}</a>
                    @endcan
                    <!-- Print Button (Hidden in Print Mode) -->
                    <button class="btn btn-warning no-print" onclick="printTable()">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>

            <div id="printableTable" class="x_content">
                <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                    <thead>
                        <tr style="height: 25px;">
                            <th style="text-align: center"> Room #</th>
                            <th style="text-align: center">Room Type</th>
                            <th style="text-align: center">{{ trans("menu.floor") }}</th>
                            <th style="text-align: center">{{ trans("menu.price") }}</th>
                            <th style="text-align: center">{{ trans("menu.desType") }}</th>
                            <th style="text-align: center">{{ trans("menu.status") }}</th>
                            <th style="text-align: center">{{ trans("menu.action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td style="text-align: center">{{ $room->room_number }}</td>
                                <td>{{$room->roomType->name }}</td>
                                <td style="text-align: center">{{ $room->floor }}</td>
                                <td style="text-align: center">${{ number_format($room->roomType->price, 2) }}</td>
                                <td>{{ Str::limit($room->description, 40) }}</td>
                                <td style="text-align: center;">
                                    @if($room->status == 'available')
                                        <span class="badge status-available">Available</span>
                                    @elseif($room->status == 'booked')
                                        <span class="badge status-booked">Booked</span>
                                    @elseif($room->status == 'maintenance')
                                        <span class="badge status-maintenance">Maintenance</span>
                                    @endif
                                </td>
                                <td style="width: 150px; text-align: center">
                                    @can("View Room")
                                        <a href="{{ url("rooms/show/" . $room->id) }}" class="btn badge bg-primary mx-3"
                                            data-toggle="tooltip" title='{{ trans("menu.showRoom") }}'><i
                                                class="fa fa-bed"></i></a>
                                    @endcan
                                    @can("Edit Room")
                                        <a href="{{ url("rooms/" . $room->id . "/edit") }}" class="btn badge bg-danger mx-3"
                                            data-toggle="tooltip" title='{{ trans("menu.editRoom") }}'
                                            style="background-color: rgba(189, 188, 188, 0.40)"><i
                                                class="fa fa-edit icon-item"></i></a>
                                    @endcan
                                    @can("Delete Room")
                                        <a href="{{ url("rooms/" . $room->id . "/delete") }}" class="btn badge bg-danger mx-3"
                                            onclick="confirmation(event)" data-toggle="tooltip"
                                            title='{{ trans("menu.deleteRoom") }}'
                                            style="background-color: rgb(110, 213, 78, 0.40)"><i
                                                class="fa fa-trash icon-ite"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function printTable() {
                const table = document.getElementById('printableTable');
                if (!table) {
                    console.error('Table with ID "printableTable" not found.');
                    return;
                }

                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write(`
    <html>

    <head>
        <title>Print Table</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #405467;
                color: #fff;
            }

            .no-print,
            .dataTables_length,
            .dataTables_filter {
                display: none;
            }
        </style>
    </head>

    <body>
        <div class="print-header">
            <h3>{{ trans('menu.roomList') }}</h3>
        </div>
        <table id="printable-table">
            ${table.innerHTML}
        </table>
    </body>

    </html>
`);

                printWindow.document.close();
                printWindow.print();
            }
        })
    </script>
@endpush
