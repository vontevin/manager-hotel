@extends("layouts.master_app")
@push("styles")
    <style>
        .checkbox-label {
            cursor: pointer;
        }

        .checkbox-input:checked::after {
            font-size: 14px;
            top: 2px;
            left: 3px;
        }

        .permission-group {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .permission-group h4 {
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
        }

        .checkbox-label {
            font-size: 16px;
            margin-left: 14px;
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
                            timer: 1500,
                            timerProgressBar: true,
                        })
                        Toast.fire({
                            icon: 'success',
                            title: "{{ session("status") }}",
                        })
                    </script>
                @endif
                <!--- ./ End Message box --->
            </div>
        </div>

    </div>
    <h3>Permission</h3>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                {{-- <h2>Role : {{$role->name}}</h2>
                <div class="clearfix"></div> --}}

                <div class="x_title">
                    <h2>Role : {{ $role->name }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li>
                            <a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- Checkbox icon to select all permissions -->
                <label for="selectAllCheckbox">
                    <input type="checkbox" id="selectAllCheckbox" class="select-all-checkbox" />
                    {{ trans("menu.selectAllPermission") }}
                </label>
                <br />
            </div>
            <div class="x_content container">
                <table id="datatable-buttons" class="table table-striped jambo_table table-bordered">
                    <form action="{{ url("roles/" . $role->id . "/give-permissions") }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="mb-3">
                            @error("permission")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <label>Permissions</label>
                            @foreach ($permissionGroups as $group => $permissions)
                                <div
                                    class="permission-group permission-group-{{ str_replace(" ", "-", strtolower($group)) }}">
                                    <h4>{{ $group }}</h4>
                                    <div class="row gap-5">
                                        <div class="checkbox-container">
                                            <!-- "Select All" Checkbox for the Group -->
                                            <label class="checkbox-label">
                                                <input type="checkbox"
                                                    id="AllCheckbox-{{ str_replace(" ", "-", strtolower($group)) }}"
                                                    class="checkbox-input" style="margin-left: 10px"
                                                    onclick="toggleGroupCheckboxes('{{ str_replace(" ", "-", strtolower($group)) }}')" />
                                                Select All
                                            </label>

                                            <!-- Permissions in the Group -->
                                            @foreach ($permissions as $permissionName)
                                                @php
                                                    $permission = $allPermissions->firstWhere("name", $permissionName);
                                                @endphp
                                                @if ($permission)
                                                    <label class="checkbox-label">
                                                        <input class="checkbox-input" type="checkbox" name="permission[]"
                                                            value="{{ $permission->name }}"
                                                            {{ in_array($permission->id, $rolePermissions) ? "checked" : "" }} />
                                                        {{ $permission->name }}
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </br>
                            <div class="mb-3 pull-right">
                                <a href="{{ route("roles.index") }}" class="btn btn-primary">
                                    {{ trans("menu.close") }}</a>
                                <button type="submit" class="btn btn-danger"> {{ trans("menu.save") }}</button>
                            </div>
                    </form>
                </table>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        // Select or deselect all checkboxes when the 'selectAllCheckbox' is clicked
        document.getElementById('selectAllCheckbox').addEventListener('change', function() {
            // Get all checkboxes with class 'checkbox-input'
            var checkboxes = document.querySelectorAll('.checkbox-input');

            // Loop through each checkbox and set its checked state to match the select-all checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = document.getElementById('selectAllCheckbox').checked;
            });
        });
    </script>
    <script>
        function toggleGroupCheckboxes(groupName) {
            const checkboxes = document.querySelectorAll(`.permission-group-${groupName} .checkbox-input:not(#AllCheckbox-${groupName})`);
            const selectAllCheckbox = document.getElementById(`AllCheckbox-${groupName}`);
    
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
@endpush
