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
				<a href="#" class="report_kejadian" onclick="loadPage('data_report_kejadian.php', ReportKejadianFunc)">Report Kejadian</a>
				|
				<a href="#" class="report_kerusakan" onclick="loadPage('data_report_kerusakan.php', ReportKerusakanFunc)">Report Kerusakan</a>
				|
				<a href="#" class="report_kecelakaan" onclick="loadPage('data_report_kecelakaan.php', ReportKecelakaanFunc)">Report Kecelakaan</a>
				|
				<a href="#" class="report_lap_kerusakan" onclick="loadPage('data_report_lap_kerusakan.php', ReportLapKerusakanFunc)">Report Laporan Kerusakan</a>
				|
				<a href="#" class="report_lap_kejadian" onclick="loadPage('data_report_lap_kejadian.php', ReportLapKejadianFunc)">Report Laporan Kejadian</a>
			</div>
			<div class="card-body">
				<div id="isi"></div>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>

<script type="text/javascript">
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

var ReportKejadianFunc = function(){
	console.log('ReportKejadian');
}

var ReportKerusakanFunc = function(){
	console.log('ReportKerusakan');
}

var ReportKecelakaanFunc = function(){
	console.log('ReportKecelakaan');
}

var ReportLapKerusakanFunc = function(){
	console.log('ReportLapKerusakan');
}

var ReportLapKejadianFunc = function(){
	console.log('ReportLapKejadian');
}

var flatpickr = function(){
	$(".from").flatpickr();
	$(".to").flatpickr();
}

loadPage('data_report_kejadian.php', ReportKejadianFunc);

var fetchExcel = function(table){
	var start = $('#from').val();
	var end = $('#to').val();
	var tb = table;
	var opr = 'export';
	$.confirm({
		title: 'Confirm!',
		content: 'Download Data ?',
		buttons: {
			confirm: function () {
				$.ajax({
					url:base_url+"helper/read.php",
					method:"POST",
					data:{table:tb,operation:opr,frm:start,to:end},
					dataType:"json",
					success:function(data)
					{
						var $a = $("<a>");
                        $a.attr("href",data.file);
                        $("body").append($a);
                        $a.attr("download",data.name+"_"+data.op+".xlsx");
                        $a[0].click();
                        $a.remove();
					}
				});
			},
			cancel: function () {
				$.alert('Hapus dibatalkan');
			},
		}
	});
}

var fetchTable = function(table, pivot){
	var start = $('#from').val();
	var end = $('#to').val();
	var tb = table;
	var pvt = pivot;
	tabelReportKejadian(start, end, tb, pvt);
}

var tabelReportKejadian = function(start, end, tb, pivot){
	var opr = 'readByDate';
	var tbl = tb;
	var dataTable = $('#'+pivot).DataTable({
		"processing":true,
		"serverSide":true,
		"destroy": true,
		"order":[],
		"ajax":{
			url:base_url+"helper/read.php",
			type:"POST",
			data:{operation:opr,table:tbl,frm:start,to:end},
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

var fetchPdf = function(table) {
	var start = $('#from').val();
	var end = $('#to').val();
	var tb = table;
	var uri = "laporan_pdf.php?from="+start+"&to="+end+"&kasus="+table;
	window.open(uri, '_blank');
}
</script>