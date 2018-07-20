<?php
  require_once "db_connect.php";
  require_once "class/User.php";

  $user = new User($db);

  if($user->isLog()){
    $dataUser = $user->getUser();
  }

?>
<?php include "view/templates/header.php"; ?>
<?php include "view/templates/menu.php"; ?>

  <!-- Header - set the background image for the header in the line below -->
  <header class="py-5 bg-image-full" style="background-image: url('https://unsplash.it/1900/1080?image=1076');">
    <img class="img-fluid d-block mx-auto" src="images/logo_polantas.png" width="150px" height="150px" alt="">
  </header>
   

  <!-- Content section -->
  <section class="py-5">
    <div class="container">
      <h1>Section Heading</h1>
      <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    </div>
  </section>
	
	<div class="container">
		<div class="row" style="margin-bottom:30px;"> 
			<div class="col-md-8">
				<!-- slider -->
				<div id="demo" class="carousel slide" data-ride="carousel">

					<!-- Indicators -->
					<ul class="carousel-indicators">
						<li data-target="#demo" data-slide-to="0" class="active"></li>
						<li data-target="#demo" data-slide-to="1"></li>
						<li data-target="#demo" data-slide-to="2"></li>
					</ul>

					<!-- The slideshow -->
					<div class="carousel-inner" id="carousel1">
						
					</div>

					<!-- Left and right controls -->
					<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>

				</div>
			</div>
			<div class="col-md-4 rightnews" id="carousel2">
				<!-- <div class="card" style="margin-bottom:15px;height:100px;">
					<div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<img src="images/noimage.png" style="width:50px;height:50px;">
							</div>
							<div class="col-md-9">
								<h6>Lorem ipsum dolor sit amet, consectetur </h6>
							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	  
		<div class="row">
			<div class="col-md-12">
				<!-- Image Section - set the background image for the header in the line below -->
				<section class="py-5 bg-image-full" style="background-image: url('https://unsplash.it/1900/1080?image=1081');">
					<!-- Put anything you want here! There is just a spacer below for demo purposes! -->
					<div style="height: 200px;"></div>
				</section>

				<!-- Content section -->
				<section class="py-5">
					<div class="container">
						<h1>Section Heading</h1>
						<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
					</div>
			  </section>
			</div>
		</div>
	</div>
 
  <!-- register modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="form-horizontal" id="register_form" method="post" action="#">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Register</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="main-login main-center">
  						<div class="form-group">
  							<label for="name" class="cols-sm-2 control-label">Nama</label>
  							<div class="cols-sm-10">
  								<div class="input-group">
  									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
  									<input type="text" class="form-control" name="reg_nama" id="reg_nama"  placeholder="Nama Lengkap Anda" required/>
  								</div>
  							</div>
  						</div>

  						<div class="form-group">
  							<label for="username" class="cols-sm-2 control-label">Username</label>
  							<div class="cols-sm-10">
  								<div class="input-group">
  									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
  									<input type="text" class="form-control" name="reg_username" id="reg_username"  placeholder="Masukkan Username Anda" required/>
  								</div>
  							</div>
  						</div>

  						<div class="form-group">
  							<label for="password" class="cols-sm-2 control-label">Password</label>
  							<div class="cols-sm-10">
  								<div class="input-group">
  									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
  									<input type="password" class="form-control" name="reg_password" id="reg_password"  placeholder="Masukkan Password Anda" required/>
  								</div>
  							</div>
  						</div>

  						<div class="form-group">
  							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
  							<div class="cols-sm-10">
  								<div class="input-group">
  									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
  									<input type="password" class="form-control" name="reg_confirm" id="reg_confirm"  placeholder="Konfirmasi Password Anda" required/>
  								</div>
  							</div>
  						</div>
  				</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
		<form class="form-horizontal" method="post" action="#" id="login_form">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="main-login main-center">
				<div class="form-group">
					<label for="username" class="cols-sm-2 control-label">Username</label>
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
							<input type="text" class="form-control" name="log_username" id="log_username"  placeholder="Enter your Username"/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="cols-sm-2 control-label">Password</label>
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
							<input type="password" class="form-control" name="log_password" id="log_password"  placeholder="Enter your Password"/>
						</div>
					</div>
				</div>
		</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
		</form>
      </div>
    </div>
  </div>

<?php include "view/templates/footer.php"; ?>

<script type="text/javascript">

// register
$(document).on('submit', '#register_form', function(event){
  event.preventDefault();
  var table = 'user';
  var operation = 'add';
  var formData = new FormData(this);
  formData.append('table', table);
  formData.append('operation', operation);
  $.ajax({
    url:"helper/insert.php",
    method:'POST',
    data:formData,
    contentType:false,
    processData:false,
    dataType:"json",
    success:function(data)
    {
		if(data.msg == 'suc'){
			$.alert(data.print);
			$('#register_form')[0].reset();
			$('#registerModal').modal('hide');
		}
		if(data.msg == 'err'){
			$.alert(data.print);
		}
    }
  });
});

// login
$(document).on('submit', '#login_form', function(event){
  event.preventDefault();
  var table = 'user';
  var operation = 'read';
  var formData = new FormData(this);
  formData.append('table', table);
  formData.append('operation', operation);
  $.ajax({
    url:"helper/read.php",
    method:'POST',
    data:formData,
    contentType:false,
    processData:false,
    dataType:"json",
    success:function(data)
    {
		if(data.msg == 'suc'){
			$.alert(data.print);
			$('#login_form')[0].reset();
			$('#loginModal').modal('hide');
			location.reload();
		}
		if(data.msg = 'err'){
			$.alert(data.print);
		}
    }
  });
});

$(window).on('load', function() {
	callCarousel();
	callRightNews();
});

var callCarousel = function()
{
	var table = 'kejadian';
  var operation = 'show';
  var formData = new FormData();
  formData.append('table', table);
  formData.append('operation', operation);
	$.ajax({
    url:"helper/read.php",
    method:'POST',
    data:formData,
    contentType:false,
    processData:false,
    dataType:"json",
    success:function(data)
    {
			var list = '';
			var act = 'active';
			for(var i = 0; i < data.length; i++){
				if(i != 0){
					var act = '';
				}
				list += carousel(data[i].judul, data[i].gambar, act);
			}
			$('#carousel1').append(list);
    }
  });
}

var callRightNews = function()
{
	var table = 'kerusakan';
  var operation = 'show';
  var formData = new FormData();
  formData.append('table', table);
  formData.append('operation', operation);
	$.ajax({
    url:"helper/read.php",
    method:'POST',
    data:formData,
    contentType:false,
    processData:false,
    dataType:"json",
    success:function(data)
    {
			var list = '';
			for(var i = 0; i < data.length; i++){
				if(i != 0){
					var act = '';
				}
				list += rightNews(data[i].judul, data[i].gambar);
			}
			$('#carousel2').append(list);
    }
  });
}

var carousel = function(judul, gambar, active) {
	return '<div class="carousel-item '+active+'">'+
							'<img src="gambar/'+gambar+'" style="width:720px;height:400px;">'+
							'<center style="padding-top:20px;"><strong>'+judul+'</strong></center>'+
					'</div>';
}

var rightNews = function(judul, gambar) {
	var res = judul.substring(0, 40)+'...';
	return '<div class="card" style="margin-bottom:15px;height:100px;">'+
					'<div class="card-body">'+
						'<div class="row">'+
							'<div class="col-md-3">'+
								'<img src="gambar/'+gambar+'" style="width:50px;height:50px;">'+
							'</div>'+
							'<div class="col-md-9">'+
								'<h6>'+res+'</h6>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
}
</script>
