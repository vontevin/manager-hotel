@extends('layouts.master_app')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>Edit Gallery</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="col-md-4 col-sm-3 col-xs-12 profile_left py-2">
                                
                    <h4 class="ff">{{ trans("menu.imageGallery") }}</h4>
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                @if($gallery->image)
                                    <img class="img-responsive avatar-view" src="{{ asset('storage/' . $gallery->image) }}" alt="Avatar" title="Change the avatar">
                                @endif 
                            </div>
                        </div>
                        <div style="margin-top: 15px">
                            <input type="file" name="image" class="form-control"/>
                        </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <h4 class="ff">{{ trans("menu.updateGallery") }}</h4>
                </div>
                <div class="col-md-8 col-sm-9 col-xs-12">
                    <div class="x_content">
                        <!-- Gallery Name -->
                        <div class="form-group">
                            <label for="name">Gallery Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $gallery->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gallery Description -->
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gallery Price -->
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $gallery->price) }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="mb-3 pull-right">
                            <a href="{{url('galleries')}}" class="btn btn-primary"><i class="fa fa-close"></i>  {{trans('menu.close')}}</a>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> {{trans('menu.save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
