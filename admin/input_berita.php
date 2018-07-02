<form method="post" action="#" id="berita_form">
	<div class="form-group">
		<label for="judul">Judul</label>
		<input type="text" class="form-control" id="judul" name="judul" placeholder="Enter Judul" required>
	</div>
	<div class="form-group">
		<label for="gambar">Gambar</label>
		<input type="file" class="form-control" id="gambar" name="gambar" required>
	</div>
	<div class="form-group">
		<div id="map" height="460px" width="100%"></div>
	</div>
	<div class="form-group">
		<label for="isi">Isi Berita</label>
		<textarea name="isi_berita" id="isi_berita"></textarea>
	</div>
	<div class="form-group">
		<center>
			<button type="submit" class="btn btn-xs btn-default">Submit</button>
		</center>
	</div>
</form>
    