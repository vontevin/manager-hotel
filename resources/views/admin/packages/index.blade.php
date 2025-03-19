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
        <h3>Package List</h3>
    </div>
    <!-- Data Table Panel -->
    <div class="x_panel">
        <div class="x_title">
            <div class="mb-3 pull-right">
                @can('Create Package')
                    <a href="{{ route('packages.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Package Item</a>
                @endcan
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Image</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <!-- Package Name -->
                            <td>{{ $package->name }}</td>
                            
                            <!-- Package Image -->
                            <td style="text-align: center;">
                                @if ($package->image)
                                    <img 
                                        src="{{ asset('storage/' . $package->image) }}" 
                                        class="rounded-image" 
                                        style="width: 75px; height: 42px; margin-left: 4px" alt="avatar"
                                    />
                                @else
                                    <span>{{ trans('menu.noImage') }}</span>
                                @endif
                            </td>

                            <!-- Package Description -->
                            <td style="width: 250px;">{{ Str::limit($package->description, 30) }}</td>
            
                            <!-- Actions -->
                            <td style="width: 150px; text-align: center">
                                @can('View Package')
                                    <a href="{{ route('packages.show', $package->id) }}" class="btn badge bg-primary mx-3" data-toggle="tooltip" title="{{ trans('menu.showPackage') }}"><i class="fa fa-eye"></i></a>
                                @endcan
                                @can('Edit Package')
                                    <a href="{{ route('packages.edit', $package->id) }}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title="{{ trans('menu.editPackage') }}" style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i></a>
                                @endcan
                                @can('Delete Package')
                                    <a href="{{ url('packages/' . $package->id . '/delete') }}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title="{{ trans('menu.deletePackage') }}" style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
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
