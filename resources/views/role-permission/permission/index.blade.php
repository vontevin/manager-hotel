@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
        }
        .icon-item{
            color: rgb(145, 89, 89)
        }
        .icon-ite{
            color: red
        }
    </style>
@endpush
@section("content")
<div class="col-md-12">
    <div class="pull-right">
        <div class="close-link">
            <!--- ./ Message box --->
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
                        title: "{{session("status")}}",
                    })
                </script>
            @endif
            <!--- ./ End Message box ---> 
        </div>
    </div>
    
</div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ trans('menu.permissionList') }}</h3>
        </div>
        <div class="x_panel">
                <div class="x_title">
                    <h2>{{ trans('menu.tablePermission') }}</h2>
                    <div class="nav navbar-right panel_toolbox">
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('menu.addPermission') }} </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped jambo_table table-bordered">
                        {{-- <table id="datatable-buttons" class="table table-striped table-bordered"> --}}
                        <thead>
                            <tr>
                                <th>{{ trans('menu.id') }}</th>
                                <th style="text-align: center">{{ trans('menu.namePermission') }}</th>
                                <th style="text-align: center">{{ trans('menu.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td style="width: 100px">{{$permission->id}}</td>
                                    <td style="text-align: center">{{$permission->name}}</td>
                                    <td style="width: 200px; text-align: center">
                                        @can('update permission')
                                            <a href="{{url('permissions/'.$permission->id.'/edit')}}" class="btn badge  mx-3" data-toggle="tooltip" title='{{ trans('menu.editPermission') }}'style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i></a>
                                        @endcan
                                        @can('delete permission')
                                            <a href="{{url('permissions/'.$permission->id.'/delete')}}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans('menu.deletePermission') }}'   style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
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

