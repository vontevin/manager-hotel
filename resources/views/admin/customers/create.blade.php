@extends("layouts.master_app")

@section("content")
<!-- Page Content -->
<div class="">
    <h3>Create Customer</h3>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><small>Create Customer</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- Create Customer Form -->
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="address">Street Address</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="city">City</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="state">State/Province</label>
                                <input type="text" name="state" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="country">Country</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="postal_code">Postal/Zip Code</label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="identification_type">Identification Type</label>
                                <select class="form-control" id="identification_type" name="identification_type">
                                    <option value="">-- Select ID Type --</option>
                                    <option value="Passport" {{ old('identification_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                    <option value="Driver's License" {{ old('identification_type') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                    <option value="National ID" {{ old('identification_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                                    <option value="Other" {{ old('identification_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="identification_number">Identification Number</label>
                                <input type="text" name="identification_number" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="gender">Gender</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="male" required> Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="female" required> Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group text-right">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary"><i class="fa fa-close"></i> Close</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                    <!-- End of Create Customer Form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection
