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
				<a href="#" class="input_berita" onclick="loadPage('input_berita.php', inputFunc)">Input Berita</a>
				|
				<a href="#" class="data_berita" onclick="loadPage('data_berita.php', dataFunc)">Data Berita</a>
			</div>
			<div class="card-body">
				<div id="isi"></div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>

<script type="text/javascript">
$(document).on('change', 'input[type="file"]', function(e){
	var fileName = e.target.files[0].name;
	var tmppath = URL.createObjectURL(e.target.files[0]);
	var img = '<img class="img-responsive img-append" src="'+tmppath+'" width="300px" height="200px">';
	$('#img').append(img);
});

var tinymceScript = function(){
	$.getScript( base_url+"js/tinymce/tinymce.min.js", function( data, textStatus, jqxhr ) {
	  console.log( "tinymceScript Load was performed." );
	  callTinyMce();
	});
}

var callTinyMce = function(){
	tinymce.init({
		selector : '#isi_berita',
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
}

var dataFunc = function(){
	tabelBerita();
}

var editFunc = function(){
	tinymceScript();
}

loadPage('input_berita.php', inputFunc);

$(document).on('submit', '#berita_form', function(event){
	event.preventDefault();
	var table = 'berita';
	var operation = 'add';
	var formData = new FormData(this);
	formData.append('table', table);
	formData.append('operation', operation);
	$.confirm({
		title: 'Confirm!',
		content: 'Input Data ?',
		buttons: {
			confirm: function () {
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
							$('.img-append').remove();
							$('#berita_form')[0].reset();
						}
						if(data.msg == 'err'){
							$.alert(data.print);
						}
					}
				});
			},
			cancel: function () {
				$.alert('Input dibatalkan');
			},
		}
	});
});

var tabelBerita = function(){
	var opr = 'read';
	var tbl = 'berita';
	var dataTable = $('#data_berita').DataTable({
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

$(document).on('click', '.delete', function(){
    var ids = $(this).attr("id");
    var tbl = 'berita';
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
							$('#data_berita').DataTable().ajax.reload();
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
    var tbl = 'berita';
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
						loadPage('edit_berita.php', editFunc);
						openModalLoader();
						setTimeout(function()
						{ 
							$('#id').val(data.id);
							$('#edit_judul').val(data.judul);
							tinymce.get("isi_berita").setContent(data.isi);
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
 
 $(document).on('submit', '#edit_berita_form', function(event){
  event.preventDefault();
  var table = 'berita';
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
							$('#edit_berita_form')[0].reset();
							loadPage('data_berita.php', dataFunc);
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
</script>