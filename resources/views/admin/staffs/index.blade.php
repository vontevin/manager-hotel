@extends("layouts.master_app")
@push("styles")
    <style>
        .x_panel {
            font-family: Hanuman, 'Times New Roman' !important;
            font-weight: 400;
            font-size: 12px;
        }
        .icon-item {
            color: rgb(145, 89, 89)
        }
        .icon-ite {
            color: red
        }
    </style>
@endpush

@section("content")
<div class="col-md-12">
    <div class="pull-right">
        <div class="close-link">
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
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>Staff List</h3>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <div class="mb-3 pull-right">
                @can('Create Staff')
                    <a href="{{ route('staffs.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>{{ trans('menu.addNew') }}</a>
                @endcan
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                <thead class="">
                    <tr style="height: 25px;">
                        <th style="text-align: center;">{{ trans('menu.name') }}</th>
                        <th style="text-align: center">Position</th>
                        <th style="text-align: center">{{ trans('menu.email') }}</th>
                        <th style="text-align: center">{{ trans('menu.phone') }}</th>
                        <th style="text-align: center">{{ trans('menu.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $staff)
                        <tr>
                            <td>{{ $staff->full_name }}</td>
                            <td style="text-align: center; color: 
                                @if($staff->position == 'Admin') red 
                                @elseif($staff->position == 'Manager') green 
                                @elseif($staff->position == 'Receptionist') blue 
                                @else black 
                                @endif;">
                                {{ $staff->position }}
                            </td>

                            <td style="text-align: center;">{{ $staff->email }}</td>
                            <td style="text-align: center;">{{ $staff->phone }}</td>
                            <td style="width: 150px; text-align: center">
                                
                                @can('View Staff')
                                <a href="{{ route('staffs.show', $staff->id) }}" class="btn badge bg-primary mx-3" data-toggle="tooltip" title="{{ trans('menu.show') }}">
                                    <i class="fa fa-eye"></i>
                                </a>       
                                @endcan
                                @can('Edit Staff')
                                    <a href="{{ route('staffs.edit', $staff->id) }}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title="{{ trans('menu.edit') }}" style="background-color: rgba(189, 188, 188, 0.40)">
                                        <i class="fa fa-edit icon-item"></i>
                                    </a> 
                                @endcan     
                                @can('Delete Staff')
                                    <a href="{{ url('staffs/'.$staff->id.'/delete') }}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title="{{ trans('menu.delete') }}" style="background-color: rgb(110, 213, 78, 0.40)">
                                        <i class="fa fa-trash icon-ite"></i>
                                    </a>
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
