<div class="row" style="margin-bottom:30px;">
	<div class="col-md-3">
		<input type="text" class="form-control from" id="from" name="from">
	</div>
	<div class="col-md-3">
		<input type="text" class="form-control to" id="to" name="to">
	</div>
	<div class="col-md-1">
		<button type="submit" onclick="fetchTable('lapKerusakan','data_report_lap_kerusakan')" class="btn btn-xs btn-default">Submit</button>
	</div>
	<div class="col-md-1">
		<button type="submit" class="btn btn-xs btn-primary">Export</button>
	</div>
</div>
<div class="table-responsive">
  <table id="data_report_lap_kerusakan" class="table table-bordered table-striped">
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