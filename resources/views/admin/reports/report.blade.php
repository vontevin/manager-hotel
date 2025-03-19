@extends("layouts.master_app")

@push("styles")
    <style>
        @media print {
            .no-print,
            .dataTables_length,
            .dataTables_filter,
            .dataTables_info,
            .dataTables_paginate {
                display: none !important;
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
                background-color: #f2f2f2;
            }

            tfoot tr td {
                font-weight: bold;
                text-align: right;
            }
        }
    </style>
@endpush

@section("content")
    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
        <h3>Report Hotel Booking</h3>
    </div>
    <div class="x_panel">
        <form method="GET" action="{{ url()->current() }}">
            <div class="x_title">
                <h2>Select Date Filter Report</h2>
                <div class="mb-3 pull-right">
                    <a href="{{ url()->current() }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
                        {{ trans("menu.reset") }}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i>
                        {{ trans("menu.filter") }}</button>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12 col-sm-9 col-xs-12">
                <div class="x_content" style="margin-top: 10px">
                    <div class="col-md-6 col-sm-2 col-xs-12 form-group">
                        <label>{{ trans("menu.years") }}</label>
                        <select name="year" class="form-control">
                            <option value="">Select Year</option>
                            @for ($i = date("Y"); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ Request::get("year") == $i ? "selected" : "" }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 col-sm-2 col-xs-12 form-group">
                        <label>{{ trans("menu.month") }}</label>
                        <select name="month" class="form-control">
                            <option value="">Select Month</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ Request::get("month") == $i ? "selected" : "" }}>
                                    {{ date("F", mktime(0, 0, 0, $i, 10)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <button class="btn btn-warning no-print" onclick="printTable()">
        <i class="fa fa-print"></i> Print
    </button>
    @if (!empty($groupedReports) && (request()->has("year") || request()->has("month")))
        @php
            $grandTotal = 0;
        @endphp
        <div class="x_panel">
            <div id="printableTable" class="x_content">
                <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                    <thead>
                        <tr style="height: 25px;">
                            <th style="text-align: center;">Ref No #</th>
                            <th>{{ trans("menu.roomName") }}</th>
                            <th>Name Customer</th>
                            <th>{{ trans("menu.checkin_date") }}</th>
                            <th>{{ trans("menu.checkout_date") }}</th>
                            <th style="text-align: center">Floor.</th>
                            <th style="text-align: center">Price</th>
                            <th style="text-align: center">Total Nights</th>
                            <th style="text-align: center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedReports as $monthYear => $reports)
                            @php $monthlyTotal = 0; @endphp
                            @foreach ($reports as $report)
                                @php
                                    $currency = session("currency", "USD");
                                    $exchangeRate = 4100;
                                    $pricePerDay = $report->room->roomType->price;
                                    $days = \Carbon\Carbon::parse($report->check_in)->diffInDays($report->check_out);
                                    $total = $pricePerDay * $days;
                                    if ($currency == "KHR") {
                                        $total *= $exchangeRate;
                                    }
                                    $monthlyTotal += $total;
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ optional($report->room)->room_number }} - {{ optional($report->room->roomType)->name }}</td> 
                                    <td>{{ optional($report->customer)->first_name }} {{ optional($report->customer)->last_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($report->check_in)->format("d F Y") }}</td>
                                    <td>{{ \Carbon\Carbon::parse($report->check_out)->format("d F Y") }}</td>
                                    <td style="text-align: center;">{{ optional($report->room)->floor }}</td>
                                    <td style="text-align: center;">{{ number_format($pricePerDay) }} $</td>
                                    <td style="text-align: center;">{{ $days }} Day</td>
                                    <td style="text-align: center;">{{ number_format($total, 2) }} {{ $currency == "KHR" ? "៛" : "USD" }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="7" style="text-align: right; font-weight: bold; font-size: 18px;">Grand Total</td>
                            <td style="text-align: center; font-weight: bold; font-size: 18px; color: red;">
                                {{ number_format($grandTotal, 2) }} {{ $currency == "KHR" ? "៛" : "USD" }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @elseif(request()->has("year") || request()->has("month"))
        <p style="color: red; font-weight: bold; text-align: center; font-size: 30px; margin-top: 60px;">📅 No Reports found for the selected dates. 😉🤞</p>
    @else
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <h3 style="margin-top: 80px;">📅 Please Select Date to apply a Filter Report.😉</h3>
        </div>
    @endif
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
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                            th { background-color: #405467; color: #fff; }
                            .no-print, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate { display: none !important; }
                            tfoot tr td { font-weight: bold; text-align: right; }
                        </style>
                    </head>
                    <body>
                        <h2 style="text-align: center;">Hotel Report</h2>
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
