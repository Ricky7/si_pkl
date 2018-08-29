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
				<a href="#" class="input_kejadian" onclick="loadPage('input_polisi.php', inputFunc)">Tambah Polisi</a>
				|
				<a href="#" class="data_kejadian" onclick="loadPage('data_polisi.php', dataFunc)">Data Polisi</a>
			</div>
			<div class="card-body">
				<div id="isi"></div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>

<!-- Modal -->
<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="change_pass_form">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-8">
                        <input type="hidden" id="idPolisi" name="id">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-xs btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
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

    var inputFunc = function(){
    }

    var dataFunc = function(){
        tabelDataPolisi();
    }

    loadPage('input_polisi.php', inputFunc);

    var tabelDataPolisi = function(){
        var opr = 'read';
        var tbl = 'polisi';
        var dataTable = $('#data_polisi').DataTable({
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
                "targets":[0],
                "orderable":false,
            },
            ],
        });
    }

    $(document).on('submit', '#polisi_form', function(event){
        event.preventDefault();
        var table = 'polisi';
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
                    $('#polisi_form')[0].reset();
                }
                if(data.msg == 'err'){
                    $.alert(data.print);
                }
            }
        });
    });

    $(document).on('click', '.pass', function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        $('#idPolisi').val(id);
    })

    $(document).on('click', '.delete', function(){
        var ids = $(this).attr("id");
        var tbl = 'polisi';
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
                                $('#data_polisi').DataTable().ajax.reload();
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

    $(document).on('submit', '#change_pass_form', function(event){
        event.preventDefault();
        var table = 'polisi';
        var operation = 'edit';
        var formData = new FormData(this);
        formData.append('table', table);
        formData.append('operation', operation);
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
                    $('#change_pass_form')[0].reset();
                    $('#changePassModal').modal('hide');
                }
                if(data.msg == 'err'){
                    $.alert(data.print);
                }
            }
        });
    });
</script>