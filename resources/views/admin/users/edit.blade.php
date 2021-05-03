@extends('admin.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->

          <?php //$this->load->view('admin/common/breadcrumb'); ?>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo url('admin/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo url('admin/user') ?>">Users</a></li>
              <li class="breadcrumb-item active">Update User</li>
            </ol>
        </div><!-- /.col -->
          

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card" style="min-height: 400px;">
                <div class="card-header bg-dark">
                  <div class="card-title">
                      Update User
                  </div>
                </div>
                @php
                $active = '';
                $deactive = '';
                if( $user->status == 1  ){
                    $active = "checked";
                }else{
                    $deactive = "checked";
                }
                @endphp
                <form method="post" action="{{url('/admin/users/update/'.$user->id)}}" enctype="multipart/form-data">
                  {{@csrf_field() }}
                  <div class="card-body">
                      
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{ $user->name }}">
                        <p class="error">
                          @error('name')
                            {{ $message }}
                          @enderror
                        </p>
                        
                        
                      </div>

                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control " id="email" placeholder="email"value="{{ $user->email }}">
                        <p class="error">
                          @error('email')
                            {{ $message }}
                          @enderror
                        </p>
                        
                        
                      </div>

                      <div class="custom-control custom-radio float-left">
                        <input type="radio" class="custom-control-input" value="1" id="statusActive" name="status" {{$active}}>
                        <label for="statusActive" class="custom-control-label">Active</label>
                      </div> 
                      <div class="custom-control custom-radio float-left ml-3">
                        <input type="radio" class="custom-control-input" value="0" id="statusBlock" name="status" {{$deactive}}>
                        <label for="statusBlock" class="custom-control-label">Not Active</label>
                      </div>
                      
                  </div>
                  <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="submit">Update</button>
                        <a href="<?php echo url('admin/users')?>" class="btn btn-secondary" >Back</a>
                      </div> 
                </form>

            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <style type="text/css">
  .invalid_login_error, .error{
    color: red;
    font-size: 16px;
  }
</style>

@endsection
  