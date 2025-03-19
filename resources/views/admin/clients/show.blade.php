@extends('layouts.master_app')

@section('content')

    <h3>{{ trans('menu.show') }}</h3>
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ trans('menu.show') }}</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                <h4 class="ff">{{ trans("menu.image") }}</h4>
                <div class="profile_img">
                    <div id="crop-avatar">
                        <!-- Display client's image -->
                        @if($client->image)
                            <img class="img-responsive avatar-view" src="{{ asset('storage/' . $client->image) }}" alt="Avatar" title="Client Image">
                        @else
                            <img class="img-responsive avatar-view" src="{{ asset('images/default-avatar.png') }}" alt="Avatar" title="No Image Available">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-12 col-xs-12">
                <h4 class="ff">{{ trans("menu.show") }}</h4>
            </div>

            <div class="col-md-8 col-sm-9 col-xs-12">
                <div class="x_content">
                    <!-- Client Name -->
                    <div class="form-group">
                        <label for="name">{{ trans('menu.name') }}:</label>
                        <input type="text" class="form-control" value="{{ $client->name }}" disabled>
                    </div>

                    <!-- Client Email -->
                    <div class="form-group">
                        <label for="email">{{ trans('menu.email') }}:</label>
                        <input type="email" class="form-control" value="{{ $client->email }}" disabled>
                    </div>

                    <!-- Client Phone -->
                    <div class="form-group">
                        <label for="phone">{{ trans('menu.phone') }}:</label>
                        <input type="text" class="form-control" value="{{ $client->phone }}" disabled>
                    </div>

                    <!-- Client Address -->
                    <div class="form-group">
                        <label for="address">{{ trans('menu.address') }}:</label>
                        <input type="text" class="form-control" value="{{ $client->address }}" disabled>
                    </div>

                    <!-- Client Description -->
                    <div class="form-group">
                        <label for="description">{{ trans('menu.desType') }}:</label>
                        <textarea class="form-control" disabled>{{ $client->description }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="mb-3 pull-right">
                        <a href="{{ url('clients') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans('menu.close') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
