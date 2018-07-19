<form method="post" action="#" id="saksi_form">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Input Data Saksi</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" id="k_id" name="k_id">
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
            <div class="card-footer">
                <center>
                    <button type="submit" onclick="addGlobal('saksi','saksi_form')" class="btn btn-sm btn-primary">Submit</button>
                </center>
            </div>
        </div>
    </div>
</form>
    