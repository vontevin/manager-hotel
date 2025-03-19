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
    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ trans("menu.userlist") }}</h3>
        </div>
        <div class="x_panel">
                <!--- ./ Title navdar --->
                <div class="x_title">
                    <h2>{{ trans("menu.tableuser") }}</h2>
                    <div class="nav navbar-right panel_toolbox">
                        @can('create user')
                            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans("menu.adduser") }} </a>
                        @endcan
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="x_content">
                    <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                        <thead class="">
                            <tr style="max-width: 50px">
                                <th>{{ trans("menu.id") }}</th>
                                <th>{{ trans("menu.name") }}</th>
                                <th>{{ trans("menu.email") }}</th>
                                <th style="text-align: center;">{{ trans("menu.status") }}</th>
                                <th style="text-align: center;">{{ trans("menu.action") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td style="width: 50px">{{ $loop->iteration }}</td>
                                    <td style="width: 150px">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="img-thumbnail" width="40">
                                        @else
                                            <img src="{{ asset('assets/production/images/user_icon.png') }}" alt="Default Profile Picture" class="img-thumbnail" width="40">
                                        @endif
                                        {{ $user->name }}
                                    </td>
                                    
                                    <td>{{$user->email}}</td>
                                    {{-- <td style="text-align: center; vertical-align: middle;">
                                        @if (!@empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                <label class="badge bg-warning mx-1" style="background-color: red">{{$rolename}}</label>
                                            @endforeach   
                                        @endif
                                    </td> --}}
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                @switch(strtolower(trim($rolename)))
                                                    @case('admin')
                                                        <label class="badge bg-success mx-1" style="background-color: rgb(205, 206, 112); color: #dc3545">{{ $rolename }}</label>
                                                        @break
                                                    @case('superadmin')
                                                        <label class="badge mx-1" style="background-color: rgb(255, 42, 0)">{{ $rolename }}</label>
                                                        @break
                                                    @case('manager')
                                                        <label class="badge mx-1" style="background-color: #0ea4e9a6">{{ $rolename }}</label>
                                                        @break
                                                    @default
                                                        <label class="badge bg-secondary mx-1" style="background-color: rgb(110, 213, 78, 0.40); color: #dc3545">{{ $rolename }}</label>
                                                @endswitch
                                            @endforeach   
                                        @endif
                                    </td>
                                    
                                    <td style="width: 200px; text-align: center">
                                        @can('edit user')
                                            <a href="{{url('users/'.$user->id.'/edit')}}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title='{{ trans('menu.editUser') }}' style="background-color: rgba(189, 188, 188, 0.40)"><i class="fa fa-edit icon-item"></i></a>
                                        @endcan
                                        @can('delete user')
                                            <a href="{{url('users/'.$user->id.'/delete')}}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans('menu.deleteUser') }}' style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
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