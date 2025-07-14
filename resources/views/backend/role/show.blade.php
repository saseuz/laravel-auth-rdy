<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Role Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Role Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Assign Permission</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Role Name : {{ $role->name }}</h5>
                                </div>
                                <div class="col-12">
                                    <form action="{{ route(admin_route_name().'roles.permissions.update', $role) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            @foreach($groups as $group)
                                            <div class="col-6 col-md-4">
                                                <div class="form-group">
                                                    <div class="bg-gradient-info custom-checkbox custom-control font-weight-bold py-2 rounded-top" style="padding-left: 30px;">
                                                        <input class="custom-control-input" type="checkbox" id="{{ $group->name }}" name="group_id" value="{{ $group->id }}">
                                                        <label for="{{ $group->name }}" class="custom-control-label">{{ $group->name }}</label>
                                                    </div>

                                                    <div class="bg-gradient-light pl-2 pt-1">
                                                        @foreach($group->permissions as $permission)
                                                        <div class="custom-control custom-checkbox">
                                                            <input 
                                                                id="{{ $permission->id }}" 
                                                                type="checkbox" 
                                                                class="custom-control-input" 
                                                                name="permissions[]"
                                                                value="{{ old('permissions', $permission->name) }}"
                                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                data-group-id="{{ $group->id }}"
                                                                >

                                                            <label for="{{ $permission->id }}" class="custom-control-label">{{ $permission->name }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <a href="{{ route(admin_route_name().'roles.index') }}" class="btn btn-default">Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@push('extra-script')
    <script>
        $(document).ready(function() {
            // Handle group checkbox click
            $('input[name="group_id"]').on('click', function() {                
                var groupId = $(this).val();
                var isChecked = $(this).is(':checked');

                // Toggle all permissions under the group
                $('input[name="permissions[]"]').each(function() {
                    if ($(this).data('group-id') == groupId) {
                        $(this).prop('checked', isChecked);
                    }
                });
            });

            $('input[name="permissions[]"]').on('click', function() {
                var groupId = $(this).data('group-id');
                var allChecked = true;

                // Check if all permissions in the group are checked
                $('input[name="permissions[]"]').each(function() {
                    if ($(this).data('group-id') == groupId && !$(this).is(':checked')) {
                        allChecked = false;
                    }
                });

                // Update the group checkbox based on permissions
                $('input[name="group_id"][value="' + groupId + '"]').prop('checked', allChecked);
            });

            $('input[name="group_id"]').each(function() {
                var groupId = $(this).val();
                var allChecked = true;

                // Check if all permissions in the group are checked
                $('input[name="permissions[]"]').each(function() {
                    if ($(this).data('group-id') == groupId && !$(this).is(':checked')) {
                        allChecked = false;
                    }
                });

                $(this).prop('checked', allChecked);
            });
        })
    </script>
@endpush
</x-admin-layout>

