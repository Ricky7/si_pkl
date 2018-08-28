<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);

	if(isset($_GET['id']))
		$idLaporan = $_GET['id'];
	else 
		$idLaporan = 0;
?>

<?php include "admin_header.php"; ?>
<?php include "admin_menu.php"; ?>
	<div class="container-fluid" id="contains">
		<div class="card">
			<div class="card-header">
				<a href="#" class="input_kecelakaan" onclick="loadPage('input_kecelakaan.php', inputFunc)">Input Kecelakaan</a>
				|
				<?php if($_SESSION['adminRole'] == 'admin') { ?>
				<a href="#" class="data_kecelakaan" onclick="loadPage('data_kecelakaan.php', dataFunc)">Data Kecelakaan
				|</a><?php } ?>
				<a href="#" class="data_kecelakaan_pending" onclick="loadPage('data_kecelakaan_pending.php', dataPendingFunc)">Data Kecelakaan Pending</a>
			</div>
			<div class="card-body">
				<div id="isi">
					
				</div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>

<!-- add data modal -->
<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div id="extraAdd"></div>
		</div>
		<div class="modal-footer">

		</div>
      </div>
    </div>
  </div>
<script type="text/javascript">

$(document).on('change', 'input[type="file"]', function(e){
	$('.img-append').remove();
	var fileName = e.target.files[0].name;
	var tmppath = URL.createObjectURL(e.target.files[0]);
	var img = '<img class="img-responsive" src="'+tmppath+'" width="300px" height="200px">';
	$('#img').append(img);
});
var tinymceScript = function(){
	$.getScript( base_url+"js/tinymce/tinymce.min.js", function( data, textStatus, jqxhr ) {
	  console.log( "tinymceScript Load was performed." );
	  callTinyMce();
	});
}

var maps = function(){
	$('.inputAddress').addressPickerByGiro({
		distanceWidget: true,
		boundElements: {
			'region': '.region',
			'county': '.county',
			'street': '.street',
			'street_number': '.street_number',
			'latitude': '.latitude',
			'longitude': '.longitude',
			'formatted_address': '.formatted_address'
		}
	});	
}

var modalCall = function (adrr){
	setTimeout(() => {
		var address = adrr;
		var id = $('#id').val();
		$.ajax({
			url: address,
			success: function(result){
				$('#extraAdd').html(result);
				$('#k_id').val(id);
			}
		});
	}, 1000);
}

var callTinyMce = function(){
	tinymce.init({
		selector : '#isi_kecelakaan',
		theme: 'modern',
		height: 300,
		plugins: [
		  'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
		  'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		  'save table contextmenu directionality emoticons template paste textcolor'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
	});	
}

var loadPage = function(adrr, callFunc) {
    var address = adrr;
	$.ajax({
       url: address,
       success: function(result){
          $('#isi').html(result);
		  callFunc();
		  flatpickr();
       }
    });
}

var inputFunc = function(){
	tinymceScript();
	maps();
}

var dataFunc = function(){
	tabelKecelakaan();
	console.log('run');
}

var dataPendingFunc = function(){
	tabelKecelakaanPending();
	console.log('data pending');
}

var editFunc = function(){
	maps();
}

var flatpickr = function(){
	$(".tgl_laka").flatpickr();
}

loadPage('input_kecelakaan.php', inputFunc);

$(document).on('submit', '#kecelakaan_form', function(event){
	event.preventDefault();
	if(isAdmin()){
		var status = 2;
	} else {
		var status = 1;
	}
	var table = 'kecelakaan';
	var operation = 'add';
	var formData = new FormData(this);
	formData.append('table', table);
	formData.append('operation', operation);
	formData.append('status', status);
	$.ajax({
		url: base_url+"helper/insert.php",
		method:'POST',
		data:formData,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(data)
		{
			if(data.msg == 'suc'){
				$.alert(data.print);
				$('#kecelakaan_form')[0].reset();
			}
			if(data.msg == 'err'){
				$.alert(data.print);
			}
		}
	});
});

var addGlobal = function(table, formName){
	event.preventDefault();
	var tbl = table;
	var operation = 'add';
	var formData = new FormData($('#'+formName)[0]);
	formData.append('table', table);
	formData.append('operation', operation);
	$.ajax({
		url: base_url+"helper/insert.php",
		method:'POST',
		data:formData,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(data)
		{
			if(data.msg == 'suc'){
				$.alert(data.print);
				$('#data_'+tbl).DataTable().ajax.reload();
				$('#'+formName)[0].reset();
				$('#addDataModal').modal('hide');
			}
			if(data.msg == 'err'){
				$.alert(data.print);
			}
		}
	});
}

var tabelKecelakaan = function(){
	var opr = 'read';
	var tbl = 'kecelakaan';
	var dataTable = $('#data_kecelakaan').DataTable({
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

var tabelKecelakaanPending = function(){
	var opr = 'read';
	var tbl = 'kecelakaanPending';
	var dataTable = $('#data_kecelakaan_pending').DataTable({
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

$(document).on('click', '.edit', function(){
	var ids = $(this).attr("id");
    var tbl = 'kecelakaan';
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
						loadPage('edit_kecelakaan.php', editFunc);
						openModalLoader();
						setTimeout(function()
						{ 
							$('#id').val(data.id);
							$('#kode').val(data.kode);
							$('#tgl').val(data.tanggal);
							$('#lokasi').val(data.lokasi);
							$('#info_jalan').val(data.info_jalan);
							$('#ket_kecelakaan').val(data.keterangan);
							extraData(data.id,'pengemudi','data_pengemudi');
							extraData(data.id,'penumpang','data_penumpang');
							extraData(data.id,'saksi','data_saksi');
							extraData(data.id,'tersangka','data_tersangka');
							extraData(data.id,'korban','data_korban');
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

var isAdmin = function(){
	var role = '<?php echo $_SESSION['adminRole']; ?>';
	if(role == 'admin'){
		return true;
	} else {
		return false;
	}
}
$(document).on('click', '.approve', function(e){
	e.preventDefault();
	if(!isAdmin()){
		$.alert('Hanya Admin Yang bisa Approve');
		return;
	}
	var ids = $(this).attr("id");
    var tbl = 'approve';
    var opr = 'edit';
	var status = 2;
	$.confirm({
		title: 'Confirm!',
		content: 'Approve Data ?',
		buttons: {
			confirm: function () {
				$.ajax({
					url:base_url+"helper/edit.php",
					method:"POST",
					data:{id:ids,table:tbl,operation:opr,status:status},
					dataType:"json",
					success:function(data)
					{
						if(data.msg == 'suc'){
							$.alert(data.print);
							$('#data_kecelakaan_pending').DataTable().ajax.reload();
						}
					}
				});
			},
			cancel: function () {
				$.alert('Edit dibatalkan');
			},
		}
	});
 })

 $(document).on('submit', '#edit_kecelakaan_form', function(event){
  event.preventDefault();
  var table = 'kecelakaan';
  var operation = 'edit';
  var formData = new FormData(this);
  formData.append('table', table);
  formData.append('operation', operation);
  $.confirm({
		title: 'Confirm!',
		content: 'Update Data ?',
		buttons: {
			confirm: function () {
				$.ajax({
					url: base_url+"helper/edit.php",
					method:'POST',
					data:formData,
					contentType:false,
					processData:false,
					dataType:"json",
					success:function(data)
					{
						if(data.msg == 'suc'){
							$.alert(data.print);
							$('#edit_kecelakaan_form')[0].reset();
							loadPage('data_kecelakaan.php', dataFunc);
						}
						if(data.msg == 'err'){
							$.alert(data.print);
						}
					}
				});
			},
			cancel: function () {
				$.alert('Update dibatalkan');
			},
		}
	});
});

var extraData = function(kid, table, datatable){
	var opr = 'read';
	var tbl = table;
	var dataTable = $('#'+datatable+'').DataTable({
		"processing":true,
		"serverSide":true,
		"destroy": true,
		"paging": false,
		"searching":false,
		"ordering":false,
		"order":[],
		"ajax":{
			url:base_url+"helper/read.php",
			type:"POST",
			data:{operation:opr,table:tbl,kecelakaan_id:kid},
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

$(document).on('click', '.delete', function(){
    var ids = $(this).attr("id");
    var tbl = $(this).attr("data-table");
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
							$('#data_'+tbl).DataTable().ajax.reload();
							$('#data_kecelakaan_pending').DataTable().ajax.reload();
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

 var showLaporan = function(){
	var id = '<?php echo $idLaporan ?>';
	if(id != 0){
		var tbl = 'laporan';
		var opr = 'readOne';
		$.ajax({
			url:base_url+"helper/read.php",
			method:"POST",
			data:{id:id,table:tbl,operation:opr},
			dataType:"json",
			success:function(data)
			{
				openModalLoader();
				setTimeout(function()
				{
					$('#ket_kecelakaan').val(data.isi);
					$('#lokasi').val(data.lokasi);
					closeModalLoader();
				}, 3000);
			}
		});
	}
	 
}
showLaporan();

</script>