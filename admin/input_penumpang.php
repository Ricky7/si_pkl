<form method="post" action="#" id="penumpang_form">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Input Data Penumpang</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" id="k_id" name="k_id">
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
            <div class="card-footer">
                <center>
                    <button type="submit" onclick="addGlobal('penumpang','penumpang_form')" class="btn btn-sm btn-primary">Submit</button>
                </center>
            </div>
        </div>
    </div>
</form>
    