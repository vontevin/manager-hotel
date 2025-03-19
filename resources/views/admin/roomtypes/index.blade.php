@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
        }

        .icon-item {
            color: rgb(145, 89, 89)
        }

        .icon-ite {
            color: red
        }

        .f_card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
            #datatable-checkbox,
            #datatable-checkbox * {
                visibility: visible;
            }

            /* Ensure table visibility */
            #datatable-checkbox {
                position: static;
                width: 100%;
                page-break-before: always;
                border: 1px solid #000;
            }

            /* Table header */
            #datatable-checkbox thead th {
                background-color: #405467 !important;
                color: #ffffff !important;
                font-weight: bold;
                text-align: center;
            }

            /* Table rows */
            #datatable-checkbox tbody tr {
                background-color: #ffffff !important;
                color: #000 !important;
            }

            /* Striped rows */
            #datatable-checkbox tbody tr:nth-child(even) {
                background-color: #d3d9e0 !important;
            }

            /* Table borders */
            #datatable-checkbox th,
            #datatable-checkbox td {
                border: 1px solid #405467 !important;
                padding: 8px;
            }

            /* Hide unnecessary elements */
            .btn,
            .no-print {
                display: none !important;
            }
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
    <div class="col-md-4 col-sm-3 col-xs-12 profile_left">
        <h3 style="margin-top: 10px">{{ trans("menu.listRoomType") }}</h3>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">

        <!--- ========== ./ This Filter Code Roomtype ============ -->

        <div class="x_panel">
            <form method="GET" action="{{ url("roomtypes") }}">
                <div class="x_title">
                    <h2>{{ trans("menu.searchTableRoomType") }}</h2>
                    <div class="mb-3 pull-right">
                        <a href="{{ url("roomtypes") }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
                            {{ trans("menu.reset") }}</a>
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-filter"></i>
                            {{ trans("menu.filter") }}</button>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12 col-sm-9 col-xs-12">
                    <div class="x_content" style="margin-top: 10px">
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.roomType") }}</label>
                            <input type="text" name="bedtype" value="{{ Request::get("bedtype") }}" class="form-control">
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.bedRoom") }}</label>
                            <input type="text" name="bedroom" value="{{ Request::get("bedroom") }}"
                                class="form-control">
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>{{ trans("menu.codeRoom") }}</label>
                            <input type="text" name="number" value="{{ Request::get("number") }}" class="form-control">
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <div class="x_panel">
            <!--- ./ Title navdar --->
            <div class="x_title">
                <div class="mb-3 pull-right">
                    @can('Create Roomtype')
                        <a href="{{ url("roomtypes/create") }}" class="btn btn-primary"><i class="fa fa-plus"></i>
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
                <table id="datatable-checkbox"
                    class="table jambo_table table-striped table-bordered col-12 md:col-6 lg:col-3">
                    <thead class="">
                        <tr>
                            <th style="text-align: center;">{{ trans("menu.image") }}</th>
                            <th>{{ trans("menu.name") }}</th>
                            <th style="text-align: center;">{{ trans("menu.maxChildren") }}</th>
                            <th style="text-align: center;">{{ trans("menu.maxAdult") }}</th>
                            <th style="text-align: center;">Amenities</th>
                            <th style="text-align: center;">{{ trans("menu.price") }}</th>
                            <th>{{ trans("menu.desType") }}</th>
                            <th style="text-align: center;">{{ trans("menu.status") }}</th>
                            <td style="text-align: center;">{{ trans("menu.action") }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roomTypes as $roomType)
                            <tr>
                                <td style="width: 100px">
                                    <img src="{{ Storage::url($roomType->image) }}" style="width: 75px; height: 42px; margin-left: 4px" alt="avatar" />
                                </td>
                                
                                <td>{{ $roomType->name }}</td>
                                <td style="text-align: center">{{ $roomType->child }}</td>
                                <td style="text-align: center">{{ $roomType->adult }}</td>

                                <td style="text-align: center; color: #dc3545">
                                    @foreach ($roomType->amenities->take(1) as $amenity)
                                        
                                        @if($amenity->name == 'WiFi') 
                                            <i class="fas fa-wifi"></i> {{ $amenity->name }} - show... <br>
                                        @elseif($amenity->name == 'Bathtub')
                                            <i class="fas fa-bath"></i> {{ $amenity->name }} - show... <br>
                                        @elseif($amenity->name == 'Minibar')
                                            <i class="fas fa-glass-martini-alt"></i> {{ $amenity->name }} - show... <br>
                                        @elseif($amenity->name == 'Air Conditioning')
                                            <i class="fas fa-fan"></i> {{ $amenity->name }} - show... <br>
                                        @elseif($amenity->name == 'Refrigerator')
                                            <i class="fas fa-ice-cream"></i> {{ $amenity->name }} - show... <br>
                                        @elseif($amenity->name == 'Restaurant')
                                            <i class="fas fa-utensils"></i> {{ $amenity->name }} - show... <br>
                                        @endif
                                    @endforeach
                                </td>                                
                                
                                @php
                                    $currency = session("currency", "USD");
                                    $exchangeRate = 4100;
                                    $price = $roomType->price;
 
                                    if ($currency == "KHR") {
                                        $price *= $exchangeRate;
                                    }
                                @endphp

                                <td style="text-align: center">
                                    {{ number_format($price, 2) }} {{ $currency == "KHR" ? "៛" : "USD" }}
                                </td>

                                <td style="width: 250px">{{ Str::limit($roomType->description, 30) }}</td>

                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($roomType->is_active)
                                        <h6 class="badge"
                                            style="background-color: rgb(54, 166, 20); color: #ffffff; padding: 5px;">
                                            {{ trans("menu.active") }}
                                        </h6>
                                    @else
                                        <h6 class="badge"
                                            style="background-color: rgb(205, 206, 112); color: #dc3545; padding: 5px;">
                                            {{ trans("menu.inactive") }}
                                        </h6>
                                    @endif
                                </td>

                                <td style="width: 150px; text-align: center">
                                    @can("View Roomtype")
                                        <a href="{{ url("roomtypes/show/" . $roomType->id) }}"
                                            class="btn badge bg-primary mx-3" data-toggle="tooltip"
                                            title='{{ trans("menu.showRoom") }}'>
                                            <i class="fa fa-bed"></i>
                                        </a>
                                    @endcan
                                    @can("Edit Roomtype")
                                        <a href="{{ url("roomtypes/" . $roomType->id . "/edit") }}"
                                            class="btn badge bg-danger mx-3" data-toggle="tooltip"
                                            title='{{ trans("menu.editRoom") }}'
                                            style="background-color: rgba(189, 188, 188, 0.40)">
                                            <i class="fa fa-edit icon-item"></i>
                                        </a>
                                    @endcan
                                    @can("Delete Roomtype")
                                        <a href="{{ url("roomtypes/" . $roomType->id . "/delete") }}"
                                            class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip"
                                            title='{{ trans("menu.deleteRoom") }}'
                                            style="background-color: rgb(110, 213, 78, 0.40)">
                                            <i class="fa fa-trash icon-ite"></i>
                                        </a>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                            th { background-color: #405467; color: #fff; }
                            .no-print, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate { display: none !important; }
                            tfoot tr td { font-weight: bold; text-align: right; }
                        </style>
                    </head>
                    <body>
                        <h2 style="text-align: center;">List/ RoomType</h2>
                        ${table.outerHTML}
                    </body>
                </html>
            `);
                printWindow.document.close();
                printWindow.print();
            }

            const printButton = document.querySelector('.btn-warning.no-print');
            if (printButton) {
                printButton.addEventListener('click', printTable);
            }
        });
    </script>
@endpush
