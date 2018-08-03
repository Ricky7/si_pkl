<form method="post" action="#" id="kecelakaan_form">
	<h3 style="padding-bottom:10px;"><center>Manajemen Data Kecelakaan</center></h3>
	<hr>
	<div class="row">
		<!-- open data kecelakaan -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Kecelakaan</h6>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-6">
							<label>Kode</label>
							<input type="text" class="form-control" id="kode" name="kode" required>
						</div>
						<div class="col-6">
							<label>Tanggal Kejadian</label>
							<input type="text" class="form-control tgl_laka" id="tgl" name="tgl" required>
						</div>
					</div>
					<div class="form-group">
						<label for="gambar">Gambar</label>
						<input type="file" class="form-control" id="gambar" name="gambar" required>
					</div>
					<div class="form-group">
						<label for="lokasi">Lokasi Kejadian</label>
						<input type="text" class="form-control inputAddress" id="lokasi" name="lokasi" required>
						<input type="hidden" class="latitude" name="lat" required>
						<input type="hidden" class="longitude" name="long" required>
						<input type="hidden" class="formatted_address" name="addr" required>
					</div>
					<div class="form-group">
						<div id="map"></div>
					</div>
					<div class="form-group">
						<label for="isi">Informasi Jalan</label>
						<textarea class="form-control" name="info_jalan" id="info_jalan" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label for="isi">Keterangan Kecelakaan</label>
						<textarea class="form-control" name="ket_kecelakaan" id="ket_kecelakaan" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- close data kecelakaan -->
		<!-- open data pengemudi -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Pengemudi</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" id="nama_pengemudi" name="nama_pengemudi" required>
					</div>
					<div class="form-group row">
						<div class="col-4">
							<label>Umur</label>
							<input type="number" class="form-control" id="umur_pengemudi" name="umur_pengemudi" required>
						</div>
						<div class="col-4">
							<label>Jenis Kelamin</label>
							<select class="form-control" id="gender_pengemudi" name="gender_pengemudi" required>
								<option></option>
								<option value="L">Laki laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-4">
							<label>Jenis SIM</label>
							<select class="form-control" id="jensim_pengemudi" name="jensim_pengemudi" required>
								<option></option>
								<option value="A">SIM A</option>
								<option value="B1">SIM B1</option>
								<option value="B2">SIM B2</option>
								<option value="C">SIM C</option>
								<option value="C1">SIM C1</option>
								<option value="C2">SIM C2</option>
								<option value="D">SIM D</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-4">
							<label>No SIM</label>
							<input type="number" class="form-control" id="sim_pengemudi" name="sim_pengemudi" required>
						</div>
						<div class="col-4">
							<label>No KTP</label>
							<input type="number" class="form-control" id="ktp_pengemudi" name="ktp_pengemudi" required>
						</div>
						<div class="col-4">
							<label>No Plat</label>
							<input type="text" class="form-control" id="plat_pengemudi" name="plat_pengemudi" required>
						</div>
					</div>
					<div class="form-group">
						<label>Info Kendaraan</label>
						<textarea class="form-control" name="info_ken_pengemudi" id="info_ken_pengemudi" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Alamat Pengemudi</label>
						<textarea class="form-control" name="alamat_pengemudi" id="alamat_pengemudi" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Keterangan Tambahan</label>
						<textarea class="form-control" name="ket_pengemudi" id="ket_pengemudi" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- close data pengemudi -->
	</div>
	<div class="row">
		<!-- open data penumpang -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Penumpang</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" id="nama_penumpang" name="nama_penumpang">
					</div>
					<div class="form-group row">
						<div class="col-2">
							<label>Umur</label>
							<input type="number" class="form-control" id="umur_penumpang" name="umur_penumpang">
						</div>
						<div class="col-4">
							<label>Jenis Kelamin</label>
							<select class="form-control" id="gender_penumpang" name="gender_penumpang">
								<option></option>
								<option value="L">Laki laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-6">
							<label>No KTP</label>
							<input type="number" class="form-control" id="ktp_penumpang" name="ktp_penumpang">
						</div>
					</div>
					<div class="form-group">
						<label>Alamat Penumpang</label>
						<textarea class="form-control" name="alamat_penumpang" id="alamat_penumpang" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Keterangan Cedera</label>
						<textarea class="form-control" name="info_cedera_penumpang" id="info_cedera_penumpang" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Keterangan Tambahan</label>
						<textarea class="form-control" name="ket_penumpang" id="ket_penumpang" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- close data penumpang -->
		<!-- open data saksi -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Saksi</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" id="nama_saksi" name="nama_saksi">
					</div>
					<div class="form-group row">
						<div class="col-2">
							<label>Umur</label>
							<input type="number" class="form-control" id="umur_saksi" name="umur_saksi">
						</div>
						<div class="col-4">
							<label>Jenis Kelamin</label>
							<select class="form-control" id="gender_saksi" name="gender_saksi">
								<option></option>
								<option value="L">Laki laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-6">
							<label>No KTP</label>
							<input type="number" class="form-control" id="ktp_saksi" name="ktp_saksi">
						</div>
					</div>
					<div class="form-group">
						<label>Alamat Saksi</label>
						<textarea class="form-control" name="alamat_saksi" id="alamat_saksi" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Pernyataan</label>
						<textarea class="form-control" name="pernyataan_saksi" id="pernyataan_saksi" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- close data saksi -->
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Tersangka</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" id="nama_tersangka" name="nama_tersangka">
					</div>
					<div class="form-group row">
						<div class="col-2">
							<label>Umur</label>
							<input type="number" class="form-control" id="umur_tersangka" name="umur_tersangka">
						</div>
						<div class="col-4">
							<label>Jenis Kelamin</label>
							<select class="form-control" id="gender_tersangka" name="gender_tersangka">
								<option></option>
								<option value="L">Laki laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-6">
							<label>No KTP</label>
							<input type="number" class="form-control" id="ktp_tersangka" name="ktp_tersangka">
						</div>
					</div>
					<div class="form-group">
						<label>Alamat Saksi</label>
						<textarea class="form-control" name="alamat_tersangka" id="alamat_tersangka" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Pernyataan</label>
						<textarea class="form-control" name="pernyataan_tersangka" id="pernyataan_tersangka" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header cardHeadLaka">
					<h6>Data Korban</h6>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" id="nama_korban" name="nama_korban">
					</div>
					<div class="form-group row">
						<div class="col-2">
							<label>Umur</label>
							<input type="number" class="form-control" id="umur_korban" name="umur_korban">
						</div>
						<div class="col-4">
							<label>Jenis Kelamin</label>
							<select class="form-control" id="gender_korban" name="gender_korban">
								<option></option>
								<option value="L">Laki laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-6">
							<label>No KTP</label>
							<input type="number" class="form-control" id="ktp_korban" name="ktp_korban">
						</div>
					</div>
					<div class="form-group">
						<label>Status Korban</label>
						<select class="form-control" id="status_korban" name="status_korban">
							<option></option>
							<option value="Tidak Meninggal">Tidak Meninggal</option>
							<option value="Meninggal">Meninggal</option>
						</select>
					</div>
					<div class="form-group">
						<label>Alamat Saksi</label>
						<textarea class="form-control" name="alamat_korban" id="alamat_korban" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label>Pernyataan</label>
						<textarea class="form-control" name="pernyataan_korban" id="pernyataan_korban" rows="5"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<center>
					<button type="submit" class="btn btn-xs btn-primary">Submit</button>
				</center>
			</div>
		</div>
	</div>
</form>