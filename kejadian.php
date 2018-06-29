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

<div class="container" style="margin-top:30px;margin-bottom:30px;">
	<div class="card">
		<div class="card-header">
			<strong>Lapor Kejadian/Kerusakan</strong>
		</div>
		<form method="post" id="laporan_form" action="#">
		<div class="card-body">
			<div class="form-group">
				<label for="judul">Judul</label>
				<input type="text" class="form-control" id="judul" name="judul" placeholder="Enter Judul" required>
			</div>
			<div class="form-group">
				<label for="jenis">Jenis</label>
				<select class="form-control" id="jenis" name="jenis" required>
					<option></option>
					<option value="1">Kejadian</option>
					<option value="2">Kerusakan</option>
				</select>
			</div>
			<div class="form-group">
				<label for="gambar">Gambar</label>
				<input type="file" class="form-control" id="gambar" name="gambar" required>
			</div>
			<div class="form-group">
				<label for="lokasi">Alamat Lokasi</label>
				<input type="text" class="form-control" id="lokasi" name="lokasi" required>
			</div>
			<div class="form-group">
				<label for="isi">Keterangan Kejadian</label>
				<textarea name="isi" id="isi" class="form-control" rows="6" required></textarea>
			</div>	
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-sm btn-default">Submit</button>
		</div>
		</form>
	</div>
</div>

<?php include "view/templates/footer.php"; ?>

<script type="text/javascript">
// post
$(document).on('submit', '#laporan_form', function(event){
  event.preventDefault();
  var table = 'laporan';
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
			$('#laporan_form')[0].reset();
		}
		if(data.msg == 'err'){
			$.alert(data.print);
		}
    }
  });
});
</script>