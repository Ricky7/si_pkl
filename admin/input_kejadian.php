<form method="post" action="#" id="kejadian_form">
	<div class="form-group">
		<label for="judul">Judul</label>
		<input type="text" class="form-control" id="judul" name="judul" placeholder="Enter Judul" required>
	</div>
	<div class="form-group">
		<label for="gambar">Gambar</label>
		<input type="file" class="form-control" id="gambar" name="gambar" required>
	</div>
	<div class="form-group">
		<label for="lokasi">Alamat Lokasi</label>
		<input type="text" class="form-control inputAddress" id="lokasi" name="lokasi" required>
		<input type="hidden" class="latitude" name="lat">
		<input type="hidden" class="longitude" name="long">
		<input type="hidden" class="formatted_address" name="addr">
	</div>
	<div class="form-group">
		<div id="map" height="460px" width="100%"></div>
	</div>
	<div class="form-group">
		<label for="isi">Keterangan Kejadian</label>
		<textarea name="isi_kejadian" id="isi_kejadian"></textarea>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-default">Submit</button>
	</div>
</form>
    