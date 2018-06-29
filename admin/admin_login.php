<?php
	error_reporting(0);
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);
	
	if($_SESSION['isAdminLog']){
		header('location: admin_index.php');
	}
?>
<?php include "admin_header.php"; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Administrator</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
    </div>
  </div>
</nav>
	
<div class="container" id="contains">    
	<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
		<div class="card" >
			<div class="card-header">
				<strong>Login Administrator</strong>
			</div>     

			<div style="padding-top:30px" class="card-body" >

				<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
					
				<form id="adminlogin_form" class="form-horizontal" role="form">
							
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="log_username" type="text" class="form-control" name="log_username" placeholder="username">                                        
					</div>
						
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="log_password" type="password" class="form-control" name="log_password" placeholder="password">
					</div>
							
					<div style="margin-top:10px" class="form-group">
						<!-- Button -->
						<div class="col-sm-12 controls">
							<button type="submit" class="btn btn-sm btn-default">Submit</button>
						</div>
					</div>  
				</form>     
			</div>                     
		</div>  
	</div>
</div>
	
<?php include "admin_footer.php"; ?>

<script type="text/javascript">
	/*
		Admin Login
	*/
	$(document).on('submit', '#adminlogin_form', function(event){
	  event.preventDefault();
	  var table = 'admin';
	  var operation = 'read';
	  var formData = new FormData(this);
	  formData.append('table', table);
	  formData.append('operation', operation);
	  $.ajax({
		url:"../helper/read.php",
		method:'POST',
		data:formData,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(data)
		{
			if(data.msg == 'suc'){
				$.alert(data.print);
				location.href = base_url+'admin/admin_index.php';
			}
			if(data.msg = 'err'){
				$.alert(data.print);
			}
		}
	  });
	});
</script>