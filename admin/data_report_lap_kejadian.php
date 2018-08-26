<div class="row">
	<div class="col-md-12">
		<strong>Report Laporan Kejadian<strong>
	</div>
</div>
<div class="row" style="margin-bottom:30px;">
	<div class="col-md-3">
		<input type="text" class="form-control from" id="from" name="from">
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control to" id="to" name="to">
	</div>
	<div class="col-md-1">
		<button type="submit" onclick="fetchTable('lapKejadian','data_report_lap_kejadian')" class="btn btn-xs btn-default">Submit</button>
	</div>
	<!-- <div class="col-md-1">
		<button type="submit" onclick="fetchExcel('lapKejadian')" class="btn btn-xs btn-primary">Export</button>
	</div> -->
	<div class="col-md-1">
		<button type="click" onclick="fetchPdf('laporKejadian')" class="btn btn-xs btn-primary">PDF</button>
	</div>
</div>
<div class="table-responsive">
  <table id="data_report_lap_kejadian" class="table table-bordered table-striped">
	<thead>
		<th>#</th>
		<th>Judul</th>
		<th width="30%">Lokasi</th>
		<th width="15%">Pelapor</th>
		<th width="20%">Tanggal</th>
	</thead>
	<tbody>
	  
	</tbody>
  </table>
</div>