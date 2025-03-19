@extends('layouts.master_app')

@section('content')

    <h3>{{ trans('menu.editManagement') }}</h3>
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ trans('menu.editManagement') }}</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image Section -->
                <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                    <h4 class="ff">{{ trans("menu.image") }}</h4>
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            @if($client->image)
                                <img class="img-responsive avatar-view" src="{{ asset('storage/' . $client->image) }}" alt="Avatar" title="Change the avatar">
                            @endif 
                        </div>
                    </div>
                    <div style="margin-top: 15px">
                        <input type="file" name="image" class="form-control"/>
                    </div>
                </div>

                <!-- Input Fields Section -->
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <h4 class="ff">{{ trans("menu.editManagement") }}</h4>
                </div>

                <div class="col-md-8 col-sm-9 col-xs-12">
                    <div class="x_content">
                        <!-- Client Name -->
                        <div class="form-group">
                            <label for="name">{{ trans('menu.name') }}:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">{{ trans('menu.email') }}:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone">{{ trans('menu.phone') }}:</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">{{ trans('menu.address') }}:</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $client->address) }}">
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">{{ trans('menu.desType') }}:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $client->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="mb-3 pull-right">
                            <a href="{{ url('clients') }}" class="btn btn-primary"><i class="fa fa-close"></i> {{ trans('menu.close') }}</a>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{ trans('menu.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
