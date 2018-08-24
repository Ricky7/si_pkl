<div class="row">
	<div class="col-md-12">
		<strong>Report Kerusakan<strong>
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
		<button type="submit" onclick="fetchTable('kerusakan','data_report_kerusakan')" class="btn btn-xs btn-default">Submit</button>
	</div>
	<div class="col-md-1">
		<button type="submit" onclick="fetchExcel('kerusakan')" class="btn btn-xs btn-primary">Export</button>
	</div>
	<div class="col-md-1">
		<button type="click" onclick="fetchPdf('kerusakan')" class="btn btn-xs btn-danger">PDF</button>
	</div>
</div>
<div class="table-responsive">
  <table id="data_report_kerusakan" class="table table-bordered table-striped">
	<thead>
		<th>#</th>
		<th>Judul</th>
		<th width="30%">Lokasi</th>
		<th width="10%">Kasus</th>
		<th width="20%">Tanggal</th>
	</thead>
	<tbody>
	  
	</tbody>
  </table>
</div>