@php
if( isset($_COOKIE['admin_email']) && !empty($_COOKIE['admin_email']) && isset($_COOKIE['admin_pass']) && !empty($_COOKIE['admin_pass']) ){
    $cookie_email = $_COOKIE['admin_email'];
    $cookie_pass = $_COOKIE['admin_pass'];
    $remmber_checked = "checked";
}else{
    $cookie_email = '';
    $cookie_pass = '';
    $remmber_checked ='';
}
@endphp

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MY Blog | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/assets/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>MY </b>Blog Login </a>
  </div>

  <?php 

    if(session('msg')) {
  ?>
    <div class="alert alert-danger mb-3">{{session('msg')}}</div>
<?php } ?>

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session  </p>

      <form action="{{url('/admin/login_submit')}}" name="loginform" id="loginform" method="post">
          {{@csrf_field() }}
        <!-- <h2 class="invalid_login_error">{{session('msg')}}</h2> -->

        <div class="input-group mb-3"> 
          <input type="text" class="form-control" name="email" id="username"  placeholder="Email" value="{{ old('email',$cookie_email) }}" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="error">
          @error('email')
            {{ $message }}
          @enderror
        </p>
        

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{ old('password', $cookie_pass) }}" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <p class="error">
          @error('password')
            {{ $message }}
          @enderror
          </p>
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="admin_remember_me" id="remember" {{$remmber_checked}}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('admin/assets/plugins/jquery/jquery.min.js') }} "></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/assets/dist/js/adminlte.min.js') }} "></script>

<style type="text/css">
  .invalid_login_error, .error{
    color: red;
    font-size: 16px;
  }
</style>
</body>
</html>
