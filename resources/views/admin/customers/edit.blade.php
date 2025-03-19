@extends("layouts.master_app")

@section("content")
<!-- page content -->

<div class="">
    <h3>Edit Customer</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Edit Customer</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- Edit Customer Form with DataTable -->
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST" id="customerForm">
                        @csrf
                        @method('PUT')

                        <!-- DataTable for Customer Details -->
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
                                    <td>First Name <span class="text-danger">*</span></td>
                                    <td>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $customer->first_name) }}" required>
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Name <span class="text-danger">*</span></td>
                                    <td>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $customer->last_name) }}" required>
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Contact Fields -->
                                <tr>
                                    <td>{{ trans('menu.email') }} <span class="text-danger">*</span></td>
                                    <td>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('menu.phone') }} <span class="text-danger">*</span></td>
                                    <td>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Address Fields -->
                                <tr>
                                    <td>{{ trans('menu.address') }}</td>
                                    <td>
                                        <textarea name="address" class="form-control" rows="4">{{ old('address', $customer->address) }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>
                                        <input type="text" name="city" class="form-control" value="{{ old('city', $customer->city) }}">
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>
                                        <input type="text" name="state" class="form-control" value="{{ old('state', $customer->state) }}">
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('menu.postal_code') }}</td>
                                    <td>
                                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $customer->postal_code) }}">
                                        @error('postal_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>
                                        <input type="text" name="country" class="form-control" value="{{ old('country', $customer->country) }}">
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Additional Details -->
                                <tr>
                                    <td>{{ trans('menu.date_of_birth') }}</td>
                                    <td>
                                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $customer->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>
                                        <select name="gender" class="form-control">
                                            <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male</option>   
                                            <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('menu.identification_type') }}</td>
                                    <td>
                                        <input type="text" name="identification_type" class="form-control" value="{{ old('identification_type', $customer->identification_type) }}">
                                        @error('identification_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('menu.identification_number') }}</td>
                                    <td>
                                        <input type="text" name="identification_number" class="form-control" value="{{ old('identification_number', $customer->identification_number) }}">
                                        @error('identification_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Description Field -->
                                <tr>
                                    <td>Description</td>
                                    <td>
                                        <textarea name="description" class="form-control" rows="4">{{ old('description', $customer->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>   
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <!-- End of DataTable Form -->

                    <!-- Submit Button -->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="mb-3 pull-right">
                                <a href="{{ route('customers.index') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
                                <button type="submit" form="customerForm" class="btn btn-danger"><i class="fa fa-save"></i> {{ trans('menu.save') }}</button>
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
        // Initialize DataTable
        $('#customerTable').DataTable({
            paging: false, // Disable pagination since this is an edit form
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
