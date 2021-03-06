<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);
?>

<?php include "admin_header.php"; ?>
<?php include "admin_menu.php"; ?>
	<div class="container" id="contains">
		<div class="card">
			<div class="card-header">
				<a href="#" class="data_laporan_kejadian" onclick="loadPage('data_laporan_kejadian.php', LapKejadianFunc)">Laporan Kejadian</a>
				|
				<a href="#" class="data_laporan_kerusakan" onclick="loadPage('data_laporan_kerusakan.php', LapKerusakanFunc)">Laporan Kerusakan</a>
			</div>
			<div class="card-body">
				<div id="isi"></div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>
<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Publish To</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-4">
				<form action="admin_kejadian_page.php" method="GET">
					<input type="hidden" name="id" id="id1">
					<input type="submit" class="btn btn-primary btn-sm" value="Post To Kejadian">
				</form>
			</div>
			<div class="col-4">
				<form action="admin_kerusakan_page.php" method="GET">
					<input type="hidden" name="id" id="id2">
					<input type="submit" class="btn btn-primary btn-sm" value="Post To Kerusakan">
				</form>
			</div>
			<div class="col-4">
				<form action="admin_kecelakaan_page.php" method="GET">
					<input type="hidden" name="id" id="id3">
					<input type="submit" class="btn btn-primary btn-sm" value="Post To Kecelakaan">
				</form>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

var loadPage = function(adrr, callFunc) {
    var address = adrr;
	$.ajax({
       url: address,
       success: function(result){
          $('#isi').html(result);
		  callFunc();
       }
    });
}

var LapKejadianFunc = function(){
	tabelLaporanKejadian();
}

var LapKerusakanFunc = function(){
	tabelLaporanKerusakan();
}

var viewLaporanFunc = function(){
	console.log('view');
}

loadPage('data_laporan_kejadian.php', LapKejadianFunc);

var tabelLaporanKerusakan = function(){
	var opr = 'read';
	var tbl = 'laporKerusakan';
	var dataTable = $('#data_laporan_kerusakan').DataTable({
		"processing":true,
		"serverSide":true,
		"destroy": true,
		"order":[],
		"ajax":{
			url:base_url+"helper/read.php",
			type:"POST",
			data:{operation:opr,table:tbl},
			dataType:"json"
		},
		"columnDefs":[
		{
			"targets":[0, 3, 4],
			"orderable":false,
		},
		],
	});
}

var tabelLaporanKejadian = function(){
	var opr = 'read';
	var tbl = 'laporKejadian';
	var dataTable = $('#data_laporan_kejadian').DataTable({
		"processing":true,
		"serverSide":true,
		"destroy": true,
		"order":[],
		"ajax":{
			url:base_url+"helper/read.php",
			type:"POST",
			data:{operation:opr,table:tbl},
			dataType:"json"
		},
		"columnDefs":[
		{
			"targets":[0, 3, 4],
			"orderable":false,
		},
		],
	});
}

$(document).on('click', '.view', function(){
	var ids = $(this).attr("id");
    var tbl = 'laporan';
    var opr = 'readOne';
	$.confirm({
		title: 'Confirm!',
		content: 'Edit Data ?',
		buttons: {
			confirm: function () {
				$.ajax({
					url:base_url+"helper/read.php",
					method:"POST",
					data:{id:ids,table:tbl,operation:opr},
					dataType:"json",
					success:function(data)
					{
						loadPage('view_laporan.php', viewLaporanFunc);
						openModalLoader();
						setTimeout(function()
						{ 
							$("#gambar").attr("src", base_url+"gambar/"+data.gambar);
							$("#myVideo").append('<source src="'+base_url+'video/'+data.video+'" type="video/mp4">');
							$('#judul').val(data.judul);
							$('#kasus').val(data.kasus);
							$('#lokasi').val(data.lokasi);
							$('#pelapor').val(data.pelapor);
							$('#isi').append(data.isi);
							closeModalLoader();
						}, 3000);
					}
				});
			},
			cancel: function () {
				$.alert('Edit dibatalkan');
			},
		}
	});
 });
 
 $(document).on('click', '.delete', function(){
    var ids = $(this).attr("id");
    var tbl = 'laporan';
    var opr = 'delete';
	$.confirm({
		title: 'Confirm!',
		content: 'Hapus Data ?',
		buttons: {
			confirm: function () {
				$.ajax({
					url:base_url+"helper/delete.php",
					method:"POST",
					data:{id:ids,table:tbl,operation:opr},
					dataType:"json",
					success:function(data)
					{
						if(data.msg == 'suc'){
							$.alert(data.print);
							$('#data_laporan_kerusakan').DataTable().ajax.reload();
							$('#data_laporan_kejadian').DataTable().ajax.reload();
						}
						if(data.msg == 'err'){
							$.alert(data.print);
						}
					  
					}
				});
			},
			cancel: function () {
				$.alert('Hapus dibatalkan');
			},
		}
	});
 });

 $(document).on('click', '.publish', function(e){
	 e.preventDefault();
	 var id = $(this).attr('id');
	 $('#id1').val(id);
	 $('#id2').val(id);
	 $('#id3').val(id);
 })
</script>