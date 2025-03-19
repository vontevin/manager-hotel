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
        <h3>Customer List</h3>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <div class="mb-3 pull-right">
                @can('Create Customer')
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Booking New</a>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>{{ trans('menu.addNew') }}</a>
                @endcan
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <table id="datatable-checkbox" class="table jambo_table table-striped table-bordered">
                <thead class="">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>{{ trans('menu.email') }}</th>
                        <th>{{ trans('menu.phone') }}</th>
                        <th>{{ trans('menu.address') }}</th>
                        {{-- <th>City</th>
                        <th>State</th>
                        <th>Country</th> --}}
                        {{-- <th>{{ trans('menu.postal_code') }}</th> --}}
                        <th>{{ trans('menu.date_of_birth') }}</th>
                        {{-- <th>{{ trans('menu.identification_type') }}</th> --}}
                        {{-- <th>{{ trans('menu.identification_number') }}</th>
                        <th>Description</th> --}}
                        <th>{{ trans('menu.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->first_name }}</td>
                            <td>{{ $customer->last_name }}</td>
                            <td>{{ $customer->gender }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            {{-- <td>{{ $customer->city }}</td>
                            <td>{{ $customer->state }}</td>
                            <td>{{ $customer->country }}</td> --}}
                            {{-- <td>{{ $customer->postal_code }}</td> --}}
                            <td>{{ $customer->date_of_birth }}</td>
                            {{-- <td>{{ $customer->identification_type }}</td> --}}
                            {{-- <td>{{ $customer->identification_number }}</td>
                            <td>{{ $customer->description }}</td>  --}}
                            <td style="width: 150px; text-align: center">
                                @can('View Customer')
                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title='{{ trans("menu.view")}}' style="background-color: rgb(255, 255, 255, 0.40)"><i class="fa fa-eye icon-item"></i></a>                                                   
                                @endcan
                                @can('Edit Customer')
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn badge bg-danger mx-3" data-toggle="tooltip" title="{{ trans('menu.edit') }}" style="background-color: rgba(189, 188, 188, 0.40)">
                                        <i class="fa fa-edit icon-item"></i>
                                    </a>
                                @endcan
                                @can('Delete Customer')                          
                                    <a href="{{url('customers/'.$customer->id.'/delete')}}" class="btn badge bg-danger mx-3" onclick="confirmation(event)" data-toggle="tooltip" title='{{ trans("menu.delete")}}' style="background-color: rgb(110, 213, 78, 0.40)"><i class="fa fa-trash icon-ite"></i></a>
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
@push("scripts")

@endpush