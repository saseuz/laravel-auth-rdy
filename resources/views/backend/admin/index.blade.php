<x-admin-layout>
    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin List</li>
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
                        <div class="card-header d-flex">
                            <h3 class="card-title mt-2 flex-grow-1">Admin List</h3>

                            @adminCan('create-role')
                            <a href="{{ route(admin_route_name().'admins.create') }}" class="btn bg-gradient-primary">
                                <i class="fa fa-plus"></i>
                                Add
                            </a>
                            @endadminCan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="list-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $i => $admin)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>
                                            @if($admin->roles->isEmpty())
                                                <span class="badge badge-warning">No Role Assigned</span>
                                            @else
                                                @foreach ($admin->roles as $role)
                                                    <span class="badge badge-info">{{ $role->name }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route(admin_route_name().'admins.show', $admin->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>

                                            @adminCan('update-admin')
                                            <a href="{{ route(admin_route_name().'admins.edit', $admin->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            @endadminCan

                                            @adminCan('delete-admin')
                                            <form action="{{ route(admin_route_name().'admins.destroy', $admin->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                            @endadminCan
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script>
    $(document).ready( function () {
        $('#list-table').DataTable({
            "responsive": true,
            "order_by": [[ 0, "desc" ]],
        });

        $('.delete-btn').on('click', function(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
            e.preventDefault();
        });
    } );
</script>
@endpush
    
</x-admin-layout>