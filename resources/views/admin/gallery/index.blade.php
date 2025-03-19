@extends('layouts.master_app')

@push('styles')
<style>
    .x_panel {
        font-family: Hanuman, 'Times New Roman' !important;
        font-weight: 400;
        font-size: 12px;
    }
    .icon-item {
        color: rgb(145, 89, 89);
    }
    .icon-ite {
        color: red;
    }
</style>
@endpush

@section('content')
<div class="col-md-12">
    <div class="pull-right">
        <div class="close-link">
            <!-- Message box -->
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
                        title: "{{ session('status') }}",
                    })
                </script>
            @endif
            <!-- End Message box -->
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
    <div class="col-md-12">
        <h3>{{ trans('menu.gallerylist') }}</h3>
    </div>

    <!-- Data Table Panel -->
    <div class="x_panel">
        <div class="x_title">
            <div class="mb-3 pull-right">
                @can('Create Gallery')
                    <a href="{{ route('galleries.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>{{ trans('menu.addNew') }}</a>
                @endcan
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('menu.name') }}</th>
                        <th class="text-center">{{ trans('menu.image') }}</th>
                        <th class="text-center">{{ trans('menu.price') }}</th>
                        <th>{{ trans('menu.desType') }}</th>
                        <th class="text-center">{{ trans('menu.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $gallery)
                        <tr>
                            <!-- Gallery Name -->
                            <td>{{ $gallery->name }}</td>
                            
                            <!-- Gallery Image -->
                            <td style="width: 100px; text-align: center;">
                                @if ($gallery->image)
                                    <img 
                                        src="{{ asset('storage/' . $gallery->image) }}" 
                                        class="rounded-image" 
                                        style="width: 75px; height: 42px; margin-left: 4px" alt="avatar"
                                    />
                                @else
                                    <span>{{ trans('menu.noImage') }}</span>
                                @endif
                            </td>
                
                            <!-- Gallery Price -->
                            <td style="text-align: center;">{{ $gallery->price }}$</td>

                            <!-- Gallery Description -->
                            <td style="width: 250px;">{{ Str::limit($gallery->description, 30) }}</td>
            
                            <!-- Actions -->
                            <td style="width: 150px; text-align: center">
                                @can('View Gallery')
                                    <a href="{{ route('galleries.show', $gallery->id) }}" class="btn badge bg-primary mx-3" data-toggle="tooltip" title="{{ trans('menu.show') }}"><i class="fa fa-eye"></i></a>
                                @endcan
                                @can('Edit Gallery')
                                    <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title="{{ trans('menu.edit') }}" style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i></a>
                                @endcan
                                @can('Delete Gallery')
                                    <a href="{{ url('galleries/' .$gallery->id . '/delete') }}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title="{{ trans('menu.delete') }}" style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
                                @endcan
                                {{-- <a href="{{url('guests/'.$guest->id.'/delete')}}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans("menu.deleteGuest")}}' style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
