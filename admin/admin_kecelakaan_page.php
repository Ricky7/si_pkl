<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);
?>

<?php include "admin_header.php"; ?>
<?php include "admin_menu.php"; ?>
	<div class="container-fluid" id="contains">
		<div class="card">
			<div class="card-header">
				<a href="#" class="input_kecelakaan" onclick="loadPage('input_kecelakaan.php', inputFunc)">Input Kecelakaan</a>
				|
				<a href="#" class="data_kecelakaan" onclick="loadPage('data_kecelakaan.php', dataFunc)">Data Kecelakaan</a>
			</div>
			<div class="card-body">
				<div id="isi">
					
				</div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>

<script type="text/javascript">
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

var editFunc = function(){
	maps();
}

var flatpickr = function(){
	$(".tgl_laka").flatpickr();
}

loadPage('input_kecelakaan.php', inputFunc);

$(document).on('submit', '#kecelakaan_form', function(event){
	event.preventDefault();
	var table = 'kecelakaan';
	var operation = 'add';
	var formData = new FormData(this);
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
				$('#kecelakaan_form')[0].reset();
			}
			if(data.msg == 'err'){
				$.alert(data.print);
			}
		}
	});
});

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
</script>