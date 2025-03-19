@extends("layouts.master_app")
@push("styles")
    
@endpush
@section("content")
    <h3>{{ trans('menu.fromEditPermission') }}</h3>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Edit <small>{{ trans('menu.fromEditPermission') }}</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <br />
            <div class="x_content">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <form action="{{ url('permissions/'.$permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="">{{ trans('menu.namePermission') }}</label>
                            <input type="text" name="name" value="{{$permission->name}}" class="form-control" />
                        </div>
                        </br>
                        <div class="mb-3 pull-right">
                            <a href="{{ route("permissions.index") }}" class="btn btn-primary"> {{ trans('menu.close') }}</a>
                            <button type="submit" class="btn btn-danger"> {{ trans('menu.save') }}</button>
                        </div>
                    </form>
                </table>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
   
@endpush
