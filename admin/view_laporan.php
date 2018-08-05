<div class="form-group">
	<center><img class="img-responsive" id="gambar" width="300px" height="200px"></center>
</div>
<div class="form-group">
	<center>
		<video id="myVideo" width="480" height="360" onclick="this.paused ? this.play() : this.pause();">
			<!-- <source id="_video" type="video/mp4"> -->
			Your browser does not support HTML5 video.
		</video>
	</center>
</div>
<div class="form-group">
	<label for="judul">Judul</label>
	<input type="text" class="form-control" id="judul" name="judul" placeholder="Enter Judul" readonly>
</div>
<div class="form-group">
	<label for="kasus">Jenis Kasus</label>
	<input type="text" class="form-control" id="kasus" name="kasus" readonly>
</div>
<div class="form-group">
	<label for="lokasi">Lokasi</label>
	<input type="text" class="form-control" id="lokasi" name="lokasi" readonly>
</div>
<div class="form-group">
	<label for="pelapor">Pelapor</label>
	<input type="text" class="form-control" id="pelapor" name="pelapor" readonly>
</div>
<div class="form-group">
	<label for="isi">Isi Laporan</label>
	<p id="isi"></p>
</div>