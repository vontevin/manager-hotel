@extends("layouts.master_app")

@section("content")
<!-- page content -->

<div class="">
    <h3>Customer Details</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Customer Details</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- Customer Details Table -->
                    <table id="customerTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('menu.field') }}</th>
                                <th>{{ trans('menu.value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Name Fields -->
                            <tr>
                                <td>First Name</td>
                                <td>{{ $customer->first_name }}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>{{ $customer->last_name }}</td>
                            </tr>

                            <!-- Contact Fields -->
                            <tr>
                                <td>{{ trans('menu.email') }}</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('menu.phone') }}</td>
                                <td>{{ $customer->phone }}</td>
                            </tr>

                            <!-- Address Fields -->
                            <tr>
                                <td>{{ trans('menu.address') }}</td>
                                <td>{{ $customer->address }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{ $customer->city }}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{ $customer->state }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('menu.postal_code') }}</td>
                                <td>{{ $customer->postal_code }}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>{{ $customer->country }}</td>
                            </tr>

                            <!-- Additional Details -->
                            <tr>
                                <td>{{ trans('menu.date_of_birth') }}</td>
                                <td>{{ $customer->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ ucfirst($customer->gender) }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('menu.identification_type') }}</td>
                                <td>{{ $customer->identification_type }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('menu.identification_number') }}</td>
                                <td>{{ $customer->identification_number }}</td>
                            </tr>

                            <!-- Description Field -->
                            <tr>
                                <td>Description</td>
                                <td>{{ $customer->description }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End of Customer Details Table -->

                    <!-- Close Button -->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="mb-3 pull-right">
                                <a href="{{ route('customers.index') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

@endsection

@push('scripts')
<!-- Include DataTables JS and CSS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable for displaying customer details
        $('#customerTable').DataTable({
            paging: false, // Disable pagination since this is a details view
            searching: false, // Disable search feature
            info: false, // Disable info
            columnDefs: [{
                targets: 0,
                className: 'dt-left' // Align the "field" column to the left
            }]
        });
    });
</script>
@endpush
