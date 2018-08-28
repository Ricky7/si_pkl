<form method="post" action="#" id="edit_kecelakaan_form">
    <div class="row">
		<!-- open data kecelakaan -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Kecelakaan</h6>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-4">
							<label>Kode</label>
                            <input type="hidden" id="id" name="id">
							<input type="text" class="form-control" id="kode" name="kode" disabled>
						</div>
						<div class="col-4">
							<label>Tanggal Kejadian</label>
							<input type="text" class="form-control tgl_laka" id="tgl" name="tgl">
						</div>
                        <div class="col-4">
						<label for="gambar">Gambar</label>
						<input type="file" class="form-control" id="gambar" name="gambar">
					</div>
					</div>
					<div class="form-group">
						<label for="lokasi">Lokasi Kejadian</label>
						<input type="text" class="form-control inputAddress" id="lokasi" name="lokasi" required>
						<input type="hidden" class="latitude" name="lat">
						<input type="hidden" class="longitude" name="long">
						<input type="hidden" class="formatted_address" name="addr">
					</div>
					<div class="form-group">
						<div id="map"></div>
					</div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="isi">Informasi Jalan</label>
                            <textarea class="form-control" name="info_jalan" id="info_jalan" rows="5"></textarea>
                        </div>
                        <div class="col-6">
                            <label for="isi">Keterangan Kecelakaan</label>
                            <textarea class="form-control" name="ket_kecelakaan" id="ket_kecelakaan" rows="5"></textarea>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
			</div>
		</div>
		<!-- close data kecelakaan -->
	</div>
    <div class="row">
        <!-- open data pengemudi -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Pengemudi</h6>
				</div>
				<div class="card-body">
                    <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="modalCall('input_pengemudi.php')" data-target="#addDataModal">+ Add Data</a>
                    <table id="data_pengemudi" class="table table-bordered table-striped">
                        <thead>
                            <th width="3%">#</th>
                            <th>Nama</th>
                            <th width="20%">Alamat</th>
                            <th width="5%">Umur</th>
                            <th>No KTP</th>
                            <th width="5%">SIM</th>
                            <th>No SIM</th>
                            <th width="10%">Gender</th>
                            <th width="10%">Aksi</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
		<!-- close data pengemudi -->
    </div>
    <div class="row">
        <!-- open data penumpang -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Penumpang</h6>
				</div>
				<div class="card-body">
                <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="modalCall('input_penumpang.php')" data-target="#addDataModal">+ Add Data</a>
                    <table id="data_penumpang" class="table table-bordered table-striped">
                        <thead>
                            <th width="3%">#</th>
                            <th>Nama</th>
                            <th width="30%">Alamat</th>
                            <th width="5%">Umur</th>
                            <th width="15%">No KTP</th>
                            <th width="10%">Gender</th>
                            <th width="10%">Aksi</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
		<!-- close data penumpang -->
    </div>
    <div class="row">
        <!-- open data saksi -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Saksi</h6>
				</div>
				<div class="card-body">
                <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="modalCall('input_saksi.php')" data-target="#addDataModal">+ Add Data</a>
                    <table id="data_saksi" class="table table-bordered table-striped">
                        <thead>
                            <th width="3%">#</th>
                            <th>Nama</th>
                            <th width="30%">Alamat</th>
                            <th width="5%">Umur</th>
                            <th width="15%">No KTP</th>
                            <th width="10%">Gender</th>
                            <th width="10%">Aksi</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
		<!-- close data saksi -->
    </div>
    <!-- <div class="row"> -->
        <!-- open data tersangka -->
		<!-- <div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Tersangka</h6>
				</div>
				<div class="card-body">
                <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="modalCall('input_tersangka.php')" data-target="#addDataModal">+ Add Data</a>
                    <table id="data_tersangka" class="table table-bordered table-striped">
                        <thead>
                            <th width="3%">#</th>
                            <th>Nama</th>
                            <th width="30%">Alamat</th>
                            <th width="5%">Umur</th>
                            <th width="15%">No KTP</th>
                            <th width="10%">Gender</th>
                            <th width="10%">Aksi</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		</div> -->
		<!-- close data tersangka -->
    <!-- </div> -->
    <div class="row">
        <!-- open data korban -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Korban</h6>
				</div>
				<div class="card-body">
                <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="modalCall('input_korban.php')" data-target="#addDataModal">+ Add Data</a>
                    <table id="data_korban" class="table table-bordered table-striped">
                        <thead>
                            <th width="3%">#</th>
                            <th>Nama</th>
                            <th width="30%">Alamat</th>
                            <th width="5%">Umur</th>
                            <th width="15%">No KTP</th>
                            <th width="10%">Gender</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
		<!-- close data korban -->
    </div>
</form>
    