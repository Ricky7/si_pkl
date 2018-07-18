<form method="post" action="#" id="pengemudi_form">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Input Data Pengemudi</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" id="k_id" name="k_id">
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
                    <div class="col-6">
                        <label>No SIM</label>
                        <input type="number" class="form-control" id="sim_pengemudi" name="sim_pengemudi" required>
                    </div>
                    <div class="col-6">
                        <label>No KTP</label>
                        <input type="number" class="form-control" id="ktp_pengemudi" name="ktp_pengemudi" required>
                    </div>
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
            <div class="card-footer">
            </div>
        </div>
    </div>
</form>
    