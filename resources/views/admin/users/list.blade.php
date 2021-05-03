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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
          	
            @if(@session('msg'))
            <div class="alert alert-success alert-dismissible">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{@session('msg')}}</strong>
            </div> 
          @endif
            
            <div class="card" style="min-height: 400px;">

              	<div class="card-header">
              		<div class="card-title" style="display: none;">
              			<form id="searchfrm" name="searchfrm" method="get" action="">
              				<div class="input-group mb-0">
              					<input type="text" name="q" value="<?php echo (!empty($search) ? $search : '' ); ?>" class="form-control" placeholder="Search">
              					<div class="input-group-append">
              						<button class="input-group-text" id="basic-addmin1">
              							<i class="fas fa-search"></i>
              						</button>
              					</div>
              				</div>
              			</form>
              		</div>
              		<div class="card-tools">
              			<a href="<?php echo url('admin/users/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create</a>
              		</div>
              	</div>
              	<div class="card-body">
              		<table class="table">
              			<tr>
              				<th>#ID</th>
                      <th>Name</th>
              				<th>Email</th>
                      <th>Create At </th>
                      <th>Status</th>
              				<th>Restore</th>
              				<th>Action</th>
              			</tr>
                    <?php 
                      $i=1;
                      if(!empty($users)){
                      foreach ($users as $user) :
                        
                    ?>
              			<tr>
                      
                      <td><?= $user->id; ?></td>   
                         
                      <td><?= $user->name?></td>   
                      <td><?= $user->email?></td>   
                        
                      
                      <td><?= date('F-j-Y', strtotime($user->created_at))?></td>

                      <td><a href="javascript:void(0)" style="padding: 10px;" class="badge <?php  echo ($user->status == 1) ? 'badge-success': 'badge-danger' ?>" onclick="activeDeactive('<?php echo $user->id ?>')"><?php echo ($user->status == 1) ? 'Active' : 'Deactive' ?></a></td>

                        <td><a href="javascript:void(0)" style="padding: 8px;" class="badge <?php  echo ($user->status == 1) ? '': 'badge-warning' ?>" onclick="restore('<?php echo $user->id ?>')"><?php echo ($user->deleted_at != NULL) ? 'Restore' : '' ?></a></td>
                      
                      <td class="">
                        <a href="<?php echo url('admin/users/edit/'.$user->id)?>"  class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a> 
                        <a href="javascript:void(0)" id="" onclick="deleteuser('<?php echo $user->id ?>')"  class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a> 
                      </td>

                    </tr>
              			<?php endforeach;?>
                    <?php }else{
                      echo "<tr><td>No Records found</td></tr>";
                    }?>
              		</table>
          
              	</div>
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
  <script type="text/javascript">

    function deleteuser(id){
      if (confirm("Are you want to sure to delete this user")) {
        //alert("<?php //echo url('/admin/users/delete')?>/"+id);
        url = "<?php echo url('/admin/users/delete')?>/"+id;
        window.location.href=url;
      }

    }
    function activeDeactive(id){
      url = "<?php echo url('/admin/users/activeDeactive')?>/"+id;
        window.location.href=url;
    }
    function restore(id){
      url = "<?php echo url('/admin/users/restore')?>/"+id;
        window.location.href=url;
    }
  </script>