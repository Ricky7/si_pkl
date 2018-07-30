<form method="post" action="#" id="korban_form">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Input Data Korban</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" id="k_id" name="k_id">
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
                    <label>Alamat Korban</label>
                    <textarea class="form-control" name="alamat_korban" id="alamat_korban" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Pernyataan</label>
                    <textarea class="form-control" name="pernyataan_korban" id="pernyataan_korban" rows="5"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <center>
                    <button type="submit" onclick="addGlobal('korban','korban_form')" class="btn btn-sm btn-primary">Submit</button>
                </center>
            </div>
        </div>
    </div>
</form>
    