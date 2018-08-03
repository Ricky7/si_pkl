<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);
?>

<?php include "admin_header.php"; ?>
<?php include "admin_menu.php"; ?>
	<div class="container-fluid" id="contains">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<strong>Laporan Warga</strong>
					</div>
					<div class="card-body">
						<div id="chart_div1"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<strong>Kasus Kejadian</strong>
					</div>
					<div class="card-body">
						<div id="chart_div2"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<strong>Kasus Kerusakan</strong>
					</div>
					<div class="card-body">
						<div id="chart_div3"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<strong>Kasus Kecelakaan</strong>
					</div>
					<div class="card-body">
						<div id="chart_div4"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="card">
			<div class="card-header">
				<strong>Dashboard</strong>
			</div>
			<div class="card-body">
				<?php
					$arr = array(
						'isLog' => $_SESSION['isAdminLog'],
						'admin_id' => $_SESSION['admin_session'],
						'admin_name' => $_SESSION['admin_nama']
					);
					
					echo '<pre>';
					echo print_r($arr);
					echo '</pre>';
				?>
			</div>
		</div> -->
	</div>
<?php include "admin_footer.php"; ?>

<script type="text/javascript">

var callAjaxRead = function(_url, formData, callback) {
    var data;
    $.ajax({
        url:_url,
        method:"POST",
        data:formData,
        dataType:"json",
        success:function(res)
        {
            data = res;
            callback(data);
        }
    });
}

var laporanGraph = function ()
{
	var formData = {
		'operation' : 'graph',
		'table' : 'laporan'
	}
	var url = base_url+"helper/read.php";

	callAjaxRead(url, formData, function(data){
		google.charts.load('current', {'packages':['bar']});
	  	google.charts.setOnLoadCallback(drawChart);

		var datax = data;

		function drawChart() {
			
			var count = Object.keys(datax).length;
			var datas = new google.visualization.DataTable();
			datas.addColumn('string', 'Tanggal');
			datas.addColumn('number', 'Laporan');

			var dt = [];
			var jl = [];
			for (i = 0; i < count; i++) {
				dt.push(datax[i]['dates']);
				jl.push(datax[i]['jlh']);
			}

			var jlh = jl.toString().split(',').map(function(el){ return +el;});
			
			for(i = 0; i < dt.length; i++)
			datas.addRow([dt[i], jlh[i]]);

			var options = {
				chart: {
					title: 'Chart',
					subtitle: 'Laporan Warga',
				},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				height: 350,
				width: 600,
				colors: ['#1b9e77', '#d95f02']
			};

			var chart = new google.charts.Bar(document.getElementById('chart_div1'));

			chart.draw(datas, google.charts.Bar.convertOptions(options));
		}
	});
}

var kejadianGraph = function ()
{
	var formData = {
		'operation' : 'graph',
		'table' : 'kejadian'
	}
	var url = base_url+"helper/read.php";

	callAjaxRead(url, formData, function(data){
		google.charts.load('current', {'packages':['bar']});
	  	google.charts.setOnLoadCallback(drawChart);

		var datax = data;

		function drawChart() {
			
			var count = Object.keys(datax).length;
			var datas = new google.visualization.DataTable();
			datas.addColumn('string', 'Tanggal');
			datas.addColumn('number', 'Kejadian');

			var dt = [];
			var jl = [];
			for (i = 0; i < count; i++) {
				dt.push(datax[i]['dates']);
				jl.push(datax[i]['jlh']);
			}

			var jlh = jl.toString().split(',').map(function(el){ return +el;});
			
			for(i = 0; i < dt.length; i++)
			datas.addRow([dt[i], jlh[i]]);

			var options = {
				chart: {
					title: 'Chart',
					subtitle: 'Kejadian',
				},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				height: 350,
				width: 600,
				colors: ['#1b9e77', '#d95f02']
			};

			var chart = new google.charts.Bar(document.getElementById('chart_div2'));

			chart.draw(datas, google.charts.Bar.convertOptions(options));
		}
	});
}

var kerusakanGraph = function ()
{
	var formData = {
		'operation' : 'graph',
		'table' : 'kerusakan'
	}
	var url = base_url+"helper/read.php";

	callAjaxRead(url, formData, function(data){
		google.charts.load('current', {'packages':['bar']});
	  	google.charts.setOnLoadCallback(drawChart);

		var datax = data;

		function drawChart() {
			
			var count = Object.keys(datax).length;
			var datas = new google.visualization.DataTable();
			datas.addColumn('string', 'Tanggal');
			datas.addColumn('number', 'Kerusakan');

			var dt = [];
			var jl = [];
			for (i = 0; i < count; i++) {
				dt.push(datax[i]['dates']);
				jl.push(datax[i]['jlh']);
			}

			var jlh = jl.toString().split(',').map(function(el){ return +el;});
			
			for(i = 0; i < dt.length; i++)
			datas.addRow([dt[i], jlh[i]]);

			var options = {
				chart: {
					title: 'Chart',
					subtitle: 'Kerusakan',
				},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				height: 350,
				width: 600,
				colors: ['#1b9e77', '#d95f02']
			};

			var chart = new google.charts.Bar(document.getElementById('chart_div3'));

			chart.draw(datas, google.charts.Bar.convertOptions(options));
		}
	});
}

var kecelakaanGraph = function ()
{
	var formData = {
		'operation' : 'graph',
		'table' : 'kecelakaan'
	}
	var url = base_url+"helper/read.php";

	callAjaxRead(url, formData, function(data){
		google.charts.load('current', {'packages':['bar']});
	  	google.charts.setOnLoadCallback(drawChart);

		var datax = data;

		function drawChart() {
			
			var count = Object.keys(datax).length;
			var datas = new google.visualization.DataTable();
			datas.addColumn('string', 'Tanggal');
			datas.addColumn('number', 'Kecelakaan');

			var dt = [];
			var jl = [];
			for (i = 0; i < count; i++) {
				dt.push(datax[i]['dates']);
				jl.push(datax[i]['jlh']);
			}

			var jlh = jl.toString().split(',').map(function(el){ return +el;});
			
			for(i = 0; i < dt.length; i++)
			datas.addRow([dt[i], jlh[i]]);

			var options = {
				chart: {
					title: 'Chart',
					subtitle: 'Kecelakaan',
				},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				height: 350,
				width: 600,
				colors: ['#1b9e77', '#d95f02']
			};

			var chart = new google.charts.Bar(document.getElementById('chart_div4'));

			chart.draw(datas, google.charts.Bar.convertOptions(options));
		}
	});
}

laporanGraph();
kejadianGraph();
kerusakanGraph();
kecelakaanGraph();

</script>