@extends("layouts.master_app")

@push("styles")
    <style>
        .payment-card {
            transition: transform 0.3s;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .payment-status {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .payment-method-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Payments</h3>
        </div>

        <!-- Filters -->
        <div class="x_panel mb-4">
            <div class="">
                <form method="GET" action="{{ route("payments.index") }}">
                    <div class="x_title">
                        <h2>Search Payment</h2>
                        <div class="mb-3 pull-right">
                            <a href="{{ route("payments.index") }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
                                {{ trans("menu.reset") }}</i></a>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i>
                                {{ trans("menu.filter") }}</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="margin-top: 10px">

                        <div class="row">
                            <!-- Payment Status Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="status">Payment Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="completed" {{ request("status") == "completed" ? "selected" : "" }}>
                                        Completed
                                    </option>
                                    <option value="pending" {{ request("status") == "pending" ? "selected" : "" }}>Pending
                                    </option>
                                    <option value="failed" {{ request("status") == "failed" ? "selected" : "" }}>Failed
                                    </option>
                                    <option value="refunded" {{ request("status") == "refunded" ? "selected" : "" }}>
                                        Refunded
                                    </option>
                                </select>
                            </div>

                            <!-- Payment Method Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" id="payment_method" name="payment_method">
                                    <option value="">All Methods</option>
                                    <option value="credit_card"
                                        {{ request("payment_method") == "credit_card" ? "selected" : "" }}>Credit Card
                                    </option>
                                    <option value="cash" {{ request("payment_method") == "cash" ? "selected" : "" }}>Cash
                                    </option>
                                    <option value="bank_transfer"
                                        {{ request("payment_method") == "bank_transfer" ? "selected" : "" }}>Bank ABA
                                    </option>
                                    <option value="paypal" {{ request("payment_method") == "paypal" ? "selected" : "" }}>
                                        PayPal
                                    </option>
                                </select>
                            </div>

                            <!-- Date From Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ request("date_from") }}">
                            </div>

                            <!-- Date To Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ request("date_to") }}">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Stats -->
        <div class="x_panel">
            <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div style="margin-top: 14px;" class="icon"><i class="fas fa-dollar-sign fa-2x text-gray-300"
                                style="margin-bottom: 44px"></i></div>
                        <div class="count">{{ $totalPayments }}</div>
                        <h3>Total Payments</h3>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div style="margin-top: 14px;" class="icon"> <i class="fas fa-money-bill-wave fa-2x text-gray-300"
                                style="margin-bottom: 44px"></i></div>
                        <div class="count">${{ number_format($totalRevenue, 2) }}</div>
                        <h3>Total Revenue</h3>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div style="margin-top: 14px;" class="icon"><i class="fas fa-check-circle fa-2x text-gray-300"
                                style="margin-bottom: 44px"></i></div>
                        <div class="count">{{ $completedPayments }}</div>
                        <h3> Completed Payments</h3>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div style="margin-top: 14px;" class="icon"> <i class="fas fa-clock fa-2x text-gray-300"
                                style="margin-bottom: 44px"></i></div>
                        <div class="count">{{ $pendingPayments }}</div>
                        <h3> Pending Payments</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments List -->
        <div class="x_panel shadow mb-4">
            <div class="mb-3 pull-right">
                @can("Create Payment")
                    <a href="{{ route("payments.create") }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> New Payment
                    </a>
                @endcan
            </div>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Payments</h6>

                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Export Options:</div>
                        <a class="dropdown-item"
                            href="{{ route("payments.export", ["format" => "csv", "status" => request("status"), "payment_method" => request("payment_method"), "date_from" => request("date_from"), "date_to" => request("date_to")]) }}">
                            <i class="fas fa-file-csv fa-sm fa-fw mr-2 text-gray-400"></i> Export CSV
                        </a>
                        <a class="dropdown-item"
                            href="{{ route("payments.export", ["format" => "pdf", "status" => request("status"), "payment_method" => request("payment_method"), "date_from" => request("date_from"), "date_to" => request("date_to")]) }}">
                            <i class="fas fa-file-pdf fa-sm fa-fw mr-2 text-gray-400"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                @if ($payments->count() > 0)
                    <div class="table-responsive">
                        <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Receipt #</th>
                                    <th>customer</th>
                                    <th>Booking #</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>
                                            <a href="{{ route("customers.show", $payment->booking->customer->id) }}">
                                                {{ $payment->booking->customer->first_name }}
                                                {{ $payment->booking->customer->last_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route("bookings.show", $payment->booking->id) }}">
                                                #{{ $payment->booking->booking_number }}
                                            </a>
                                        </td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @if ($payment->payment_method == "credit_card")
                                                <i class="fas fa-credit-card text-primary"></i> Credit Card
                                                @if ($payment->card_last_four)
                                                    (**** {{ $payment->card_last_four }})
                                                @endif
                                            @elseif($payment->payment_method == "cash")
                                                <i class="fas fa-money-bill-wave text-success"></i> Cash
                                            @elseif($payment->payment_method == "bank_transfer")
                                            <img src="{{ asset('assets/production/images/aba.jpg') }}" alt="Bank ABA" style="width: 15px; height: 15px;"> ABA Bank
                                            @elseif($payment->payment_method == "paypal")
                                                <i class="fab fa-paypal text-primary"></i> PayPal
                                            @else
                                                {{ ucfirst(str_replace("_", " ", $payment->payment_method)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment->status == "completed")
                                                <span class="badge" style="background-color: #28a745; color: white;">Completed</span>
                                            @elseif($payment->status == "pending")
                                                <span class="badge" style="background-color: #ffc107; color: black;">Pending</span>
                                            @elseif($payment->status == "failed")
                                                <span class="badge" style="background-color: #dc3545; color: white;">Failed</span>
                                            @elseif($payment->status == "refunded")
                                                <span class="badge" style="background-color: #17a2b8; color: white;">Refunded</span>
                                            @else
                                                <span class="badge" style="background-color: #6c757d; color: white;">{{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </td>                                        
                                        <td>{{ $payment->payment_date->format("M d, Y H:i") }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @can("View Payment")
                                                    <a href="{{ route("payments.show", $payment->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can("Generate Receipt")
                                                    <a href="{{ route("payments.receipt", $payment->id) }}"
                                                        class="btn btn-sm btn-info" target="_blank">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                @endcan
                                                @can("Delete Payment")
                                                    <a href="{{ url("payments/" . $payment->id . "/delete") }}"
                                                        class="btn btn-sm bg-danger mx-3" onclick="confirmation(event)"
                                                        title="{{ trans("menu.delete") }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endcan
                                                @if ($payment->status == "pending")
                                                    @can("Edit Payment")
                                                        <a href="{{ route("payments.edit", $payment->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <img src="{{ asset("images/no-data.svg") }}" alt="No Payments" class="img-fluid mb-3"
                            style="max-height: 200px;">
                        <h4 class="text-muted">No payments found</h4>
                        <p>There are no payments matching your criteria.</p>
                        <a href="{{ route("payments.create") }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle"></i> Create New Payment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            // Initialize datatable
            $('#paymentsTable').DataTable({
                "paging": false,
                "ordering": true,
                "info": false,
                "searching": false
            });
        });
    </script>
@endpush
