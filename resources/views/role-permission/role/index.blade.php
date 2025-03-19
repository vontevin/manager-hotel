@extends("layouts.master_app")
@push("styles")
<style>
    .x_panel {
        font-family: Hanuman, 'Times New Roman' !important;
        font-weight: 400;
    }
    .text{
        color: rgb(129, 78, 78)
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
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ trans('menu.roleList') }}</h3>
        </div>
        <div class="x_panel">

            <div class="x_title">
                <h2>{{ trans('menu.tableRole') }}</h2>
                <div class="nav navbar-right panel_toolbox">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>{{ trans('menu.addRole') }}</a>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <table id="datatable-buttons" class="table table-striped jambo_table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('menu.id') }}</th>
                            <th>{{ trans('menu.nameRole') }}</th>
                            <th>{{ trans('menu.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td style="width: 50px">{{ $loop->iteration }}</td>
                                <td>{{$role->name}}</td>
                                <td style="">
                                        <a href="{{url('roles/'.$role->id.'/give-permissions')}}" class="btn  badge bg-primary mx-3 text" data-toggle="tooltip" title='{{ trans('menu.editRole') }}' style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i>{{ trans('menu.editRole') }}</a>
                                        <a href="{{url('roles/'.$role->id.'/edit')}}" class="btn badge mx-3" data-toggle="tooltip" title='{{ trans('menu.edit') }}' style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i></a>
                                        <a href="{{url('roles/'.$role->id.'/delete')}}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans('menu.deleteRole') }}'  style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

