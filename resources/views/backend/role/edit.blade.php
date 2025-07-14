<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit Role</li>
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
                        
                        <form action="{{ route(admin_route_name().'roles.update', $role->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-header">
                                <h3 class="card-title">Edit Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Role Name" id="role-name" name="name" value="{{ $role->name ?? old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                            
                            <div class="card-footer">
                                <div class="">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="{{ route(admin_route_name().'roles.index') }}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
</x-admin-layout>

