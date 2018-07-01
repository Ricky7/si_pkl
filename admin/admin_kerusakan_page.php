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
				<a href="#" class="input_kerusakan" onclick="loadPage('input_kejadian.php', inputFunc)">Input Kejadian</a>
				|
				<a href="#" class="data_kerusakan" onclick="loadPage('data_kejadian.php', dataFunc)">Data Kejadian</a>
			</div>
			<div class="card-body">
				<div id="isi"></div>
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
		selector : '#isi_kerusakan',
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
       }
    });
}

var inputFunc = function(){
	tinymceScript();
	maps();
}

var dataFunc = function(){
	tabelKerusakan();
	console.log('run');
}

var editFunc = function(){
	tinymceScript();
}

loadPage('input_kerusakan.php', inputFunc);

$(document).on('submit', '#kerusakan_form', function(event){
  event.preventDefault();
  var table = 'kerusakan';
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
			$('#kerusakan_form')[0].reset();
		}
		if(data.msg == 'err'){
			$.alert(data.print);
		}
    }
  });
});

$(document).on('submit', '#edit_kerusakan_form', function(event){
  event.preventDefault();
  var table = 'kerusakan';
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
							$('#edit_kerusakan_form')[0].reset();
							loadPage('data_kerusakan.php', dataFunc);
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

var tabelKerusakan = function(){
	var opr = 'read';
	var tbl = 'kerusakan';
	var dataTable = $('#data_kerusakan').DataTable({
		"processing":true,
		"serverSide":true,
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

$(document).on('click', '.delete', function(){
    var ids = $(this).attr("id");
    var tbl = 'kerusakan';
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
					success:function(data)
					{
						if(data.msg == 'suc'){
							$.alert(data.print);
							$('#data_kejadian').ajax.reload();
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
 
 $(document).on('click', '.edit', function(){
	var ids = $(this).attr("id");
    var tbl = 'kerusakan';
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
						loadPage('edit_kerusakan.php', editFunc);
						setTimeout(function()
						{ 
							$('#id').val(data.id);
							$('#edit_judul').val(data.judul);
							tinymce.get("isi_kerusakan").setContent(data.isi);
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
</script>