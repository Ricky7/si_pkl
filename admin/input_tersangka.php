<form method="post" action="#" id="tersangka_form">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Input Data Tersangka</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" id="k_id" name="k_id">
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
                    <label>Alamat Tersangka</label>
                    <textarea class="form-control" name="alamat_tersangka" id="alamat_tersangka" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Pernyataan</label>
                    <textarea class="form-control" name="pernyataan_tersangka" id="pernyataan_tersangka" rows="5"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <center>
                    <button type="submit" onclick="addGlobal('tersangka','tersangka_form')" class="btn btn-sm btn-primary">Submit</button>
                </center>
            </div>
        </div>
    </div>
</form>
    