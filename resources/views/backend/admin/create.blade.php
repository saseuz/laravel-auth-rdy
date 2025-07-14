<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route(admin_route_name().'admins.index') }}">Admins</a></li>
                        <li class="breadcrumb-item active">Add Admin</li>
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
                        <form action="{{ route(admin_route_name().'admins.store')}}" method="POST">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Add Admin</h3>
                            </div>
                            
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email" id="email" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" id="name" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" id="password" name="password" value="{{ old('password') }}">
                                            @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                            @error('password_confirmation')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role <span class="text-danger">*</span></label>
                                            <select class="custom-select @error('role_id') is-invalid @enderror" id="role" name="role_id">
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $id => $role)
                                                    <option value="{{ $role }}" @if(old('role_id') == $role) selected @endif>{{ $role }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
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
                                    <a href="{{ route(admin_route_name().'admins.index') }}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
</x-admin-layout>

