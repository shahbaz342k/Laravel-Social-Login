@extends('admin.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->

          <?php //$this->load->view('admin/common/breadcrumb'); ?>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo url('admin/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo url('admin/profile') ?>">profiles</a></li>
              <li class="breadcrumb-item active">Update Password</li>
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
                      Update Password
                  </div>
                </div>
               
                <form method="post" action="{{url('/admin/profile/update/'.$profile->id)}}" enctype="multipart/form-data">
                  {{@csrf_field() }}
                  <div class="card-body">
                      
              
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password"  >
                      </div>
                      <p class="error">
                        @error('password')
                          {{ $message }}
                        @enderror
                      </p>

                      <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control " placeholder="Confirm Password" >
                      </div>
                      <p class="error">
                        @error('password_confirmation')
                          {{ $message }}
                        @enderror
                      </p>
                      
                  </div>
                  <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="submit">Update</button>
                        <a href="<?php echo url('admin/dashboard')?>" class="btn btn-secondary" >Back</a>
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
@endsection
  <style type="text/css">
  .error{
    color: red;
    font-size: 16px;
  }
</style>