<div class="row">
	<div class="col-md-12">
		<strong>Report Kecelakaan<strong>
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
		<button type="submit" onclick="fetchTable('kecelakaan','data_report_kecelakaan')" class="btn btn-xs btn-default">Submit</button>
	</div>
	<!-- <div class="col-md-1">
		<button type="submit" onclick="fetchExcel('kecelakaan')" class="btn btn-xs btn-primary">Export</button>
	</div> -->
	<div class="col-md-1">
		<button type="click" onclick="fetchPdf('kecelakaan')" class="btn btn-xs btn-primary">PDF</button>
	</div>
</div>
<div class="table-responsive">
  <table id="data_report_kecelakaan" class="table table-bordered table-striped">
	<thead>
		<th width="5%">#</th>
		<th>kode</th>
		<th width="20%">Tanggal</th>
        <th width="10%">Penumpang</th>
        <th width="10%">Saksi</th>
        <th width="10%">Tersangka</th>
        <th width="10%">Korban</th>
	</thead>
	<tbody>
	  
	</tbody>
  </table>
</div>