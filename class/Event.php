<?php 
	class Event{
		
		private $db;
		private $error;

		function __construct($db_conn)
		{
			$this->db = $db_conn;
			date_default_timezone_set('Asia/Jakarta');
		}
		
		public function insertKejadian($data = array())
		{
			try
			  {
				$this->db->beginTransaction();	
				$addKejadian = $this->db->prepare("
					INSERT INTO kejadian(judul, isi, gambar, alamat, lat, lng, tgl_buat, id_admin, id_kasus)
					VALUES (:judul, :isi, :gambar, :alamat, :lat, :lng, NOW(), :id_admin, :id_kasus);
				");
				$addKejadian->bindParam(":judul", $data['judul']);
				$addKejadian->bindParam(":isi", $data['isi']);
				$addKejadian->bindParam(":gambar", $data['gambar']);
				$addKejadian->bindParam(":alamat", $data['addr']);
				$addKejadian->bindParam(":lat", $data['lat']);
				$addKejadian->bindParam(":lng", $data['long']);
				$addKejadian->bindParam(":id_admin", $data['admin']);
				$addKejadian->bindParam(":id_kasus", $data['kasus']);
				$addKejadian->execute();
				
				$this->db->commit();

				return $this->output('suc','Berhasil Melapor');
			  }catch(PDOException $e){
				  // Jika terjadi error
				$this->db->rollBack();
				return $this->output('err',$e->getMessage());
			  }
		}
		
		public function delKejadian($id)
		{
			try {
				$statement = $this->db->prepare(
					"DELETE FROM kejadian WHERE id = :id"
				);
				$result = $statement->execute(
					array(
						':id'	=>	$id
					)
				);
				return $this->output('suc', 'Berhasil Dihapus');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}
		
		public function fetchKejadian($id)
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT * FROM kejadian 
				WHERE id = '".$id."' 
				LIMIT 1"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output['id'] = $row["id"];
				$output["judul"] = $row["judul"];
				$output["isi"] = $row["isi"];
				$output["alamat"] = $row["alamat"];
			}
			echo json_encode($output);
		}

		public function fetchKecelakaan($id)
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT *,DATE(tanggal) as tgl FROM kecelakaan
				WHERE id = '".$id."'
				LIMIT 1"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output['id'] = $row['id'];
				$output['kode'] = $row['kode'];
				$output['tanggal'] = $row['tgl'];
				$output['lokasi'] = $row['lokasi'];
				$output['lat'] = $row['lng'];
				$output['gambar'] = $row['gambar'];
				$output['keterangan'] = $row['keterangan'];
				$output['info_jalan'] = $row['info_jalan'];
			}
			echo json_encode($output);
		}
		
		public function updateKejadian($data = array())
		{
			try {
				$sql = $this->db->prepare(
					"UPDATE kejadian SET isi = :isi WHERE id = :id"
				);
				$sql->bindparam(':isi', $data['isi']);      
			    $sql->bindparam(':id', $data['id']);
			    $sql->execute();
				
				return $this->output('suc', 'Berhasil Diupdate');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}

		public function updateKecelakaan($data = array())
		{
			try {
				$this->db->beginTransaction();
				$sql = "UPDATE kecelakaan SET ";
				if(!empty($data['tanggal'])) $sql .= "tanggal = '".$data['tanggal']."', ";
				if(!empty($data['lokasi'])) $sql .= "lokasi = '".$data['lokasi']."', ";
				if(!empty($data['lat'])) $sql .= "lat = '".$data['lat']."', ";
				if(!empty($data['lng'])) $sql .= "lng = '".$data['lng']."', ";
				if(!empty($data['gambar'])) $sql .= "gambar = '".$data['gambar']."', ";
				if(!empty($data['keterangan'])) $sql .= "keterangan = '".$data['keterangan']."', ";
				if(!empty($data['info_jalan'])) $sql .= "info_jalan = '".$data['info_jalan']."', ";
				$sql .= "updateAt = NOW() WHERE id = '".$data['id']."'";

				$query = $this->db->prepare($sql);
				$query->execute();

				$this->db->commit();

				return $this->output('suc', 'Berhasil Diupdate');
			} catch (PDOException $e){
				$this->db->rollBack();
				return $this->output('err',$e->getMessage());
			}
		}
		
		public function insertBerita($data = array())
		{
			try
			  {
				$this->db->beginTransaction();	
				$addKejadian = $this->db->prepare("
					INSERT INTO berita(judul, isi, gambar, tgl_buat, id_admin)
					VALUES (:judul, :isi, :gambar, NOW(), :id_admin);
				");
				$addKejadian->bindParam(":judul", $data['judul']);
				$addKejadian->bindParam(":isi", $data['isi']);
				$addKejadian->bindParam(":gambar", $data['gambar']);
				$addKejadian->bindParam(":id_admin", $data['admin']);;
				$addKejadian->execute();
				
				$this->db->commit();

				return $this->output('suc','Berhasil Input Berita');
			  }catch(PDOException $e){
				  // Jika terjadi error
				$this->db->rollBack();
				return $this->output('err',$e->getMessage());
			  }
		}
		
		public function delBerita($id)
		{
			try {
				$statement = $this->db->prepare(
					"DELETE FROM berita WHERE id = :id"
				);
				$result = $statement->execute(
					array(
						':id'	=>	$id
					)
				);
				return $this->output('suc', 'Berhasil Dihapus');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}
		
		public function fetchBerita($id)
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT * FROM berita 
				WHERE id = '".$id."' 
				LIMIT 1"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output['id'] = $row["id"];
				$output["judul"] = $row["judul"];
				$output["isi"] = $row["isi"];
			}
			echo json_encode($output);
		}
		
		public function updateBerita($data = array())
		{
			try {
				$sql = $this->db->prepare(
					"UPDATE berita SET isi = :isi WHERE id = :id"
				);
				$sql->bindparam(':isi', $data['isi']);      
			    $sql->bindparam(':id', $data['id']);
			    $sql->execute();
				
				return $this->output('suc', 'Berhasil Diupdate');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}
		
		public function fetchLaporan($id)
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT * FROM laporan a INNER JOIN users b
				ON (b.id = a.id_user)
				WHERE a.id = '".$id."' 
				LIMIT 1"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output['judul'] = $row["judul"];
				$output["kasus"] = $row["jenis_laporan"];
				$output["lokasi"] = $row["lokasi"];
				$output["pelapor"] = $row["nama"];
				$output["isi"] = $row["isi"];
				$output["gambar"] = $row["gambar"];
			}
			echo json_encode($output);
		}
		
		public function delLaporan($id)
		{
			try {
				$statement = $this->db->prepare(
					"DELETE FROM laporan WHERE id = :id"
				);
				$result = $statement->execute(
					array(
						':id'	=>	$id
					)
				);
				return $this->output('suc', 'Berhasil Dihapus');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}

		public function delData($id, $table)
		{
			try {
				$statement = $this->db->prepare(
					"DELETE FROM ".$table." WHERE id = :id"
				);
				$result = $statement->execute(
					array(
						':id'	=>	$id
					)
				);
				return $this->output('suc', 'Berhasil Dihapus');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}
		
		public function exportKejadian($data = array())
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT a.id as idK, a.judul, b.nama_kasus, a.tgl_buat, a.alamat FROM kejadian a INNER JOIN kasus b 
					ON (b.id = a.id_kasus) 
					WHERE DATE(a.tgl_buat) 
					BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.id_kasus = '".$data['kasus']."'"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			$i = 1; 
			foreach($result as $row)
			{
				$output[$i]['id'] = $row["idK"];
				$output[$i]["judul"] = $row["judul"];
				$output[$i]["lokasi"] = $row["alamat"];
				$output[$i]["kasus"] = $row["nama_kasus"];
				$output[$i]["tanggal"] = $row["tgl_buat"];
				$i++;
			}
			return $output;
		}

		public function exportKecelakaan($data = array())
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT a.id, a.kode, DATE(a.tanggal) as tgl, a.keterangan FROM kecelakaan a 
					WHERE DATE(a.createAt) 
					BETWEEN '".$data['from']."' AND '".$data['to']."'"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			$i = 1; 
			foreach($result as $row)
			{
				$output[$i]['id'] = $row["id"];
				$output[$i]["kode"] = $row["kode"];
				$output[$i]["tanggal"] = $row["tgl"];
				$output[$i]["keterangan"] = $row["keterangan"];
				$i++;
			}
			return $output;
		}
		
		public function exportKeluhan($data = array())
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT a.id as idL,a.judul, a.lokasi, a.tgl_lapor, b.nama 
				FROM laporan a INNER JOIN users b ON (b.id = a.id_user) 
					WHERE DATE(a.tgl_lapor) 
					BETWEEN '".$_POST['frm']."' AND '".$_POST['to']."' AND a.jenis_laporan = '".$data['kasus']."' "
			);
			$statement->execute();
			$result = $statement->fetchAll();
			$i = 1; 
			foreach($result as $row)
			{
				$output[$i]['id'] = $row["idL"];
				$output[$i]["judul"] = $row["judul"];
				$output[$i]["lokasi"] = $row["lokasi"];
				$output[$i]["pelapor"] = $row["nama"];
				$output[$i]["tanggal"] = $row["tgl_lapor"];
				$i++;
			}
			return $output;
		}

		public function insertKecelakaan($data_laka = array(), $data_pengemudi = array(), $data_penumpang = array(), $data_saksi = array(), $data_tersangka = array(), $data_korban = array())
		{
			try
			  {
				$this->db->beginTransaction();	
				$this->setLaka($data_laka);
				$lastId = $this->db->lastInsertId();
				$this->setPengemudi($data_pengemudi, $lastId);
				$this->setPenumpang($data_penumpang, $lastId);
				$this->setSaksi($data_saksi, $lastId);
				$this->setTersangka($data_tersangka, $lastId);
				$this->setKorban($data_korban, $lastId);
				$this->db->commit();

				return $this->output('suc','Berhasil Melapor');
			  }catch(PDOException $e){
				  // Jika terjadi error
				$this->db->rollBack();
				return $this->output('err',$e->getMessage());
			  }
		}

		private function setLaka($data = array())
		{
			$add = $this->db->prepare("
				INSERT INTO kecelakaan(kode, tanggal, lokasi, lat, lng, gambar, keterangan, info_jalan, admin_id, createAt, updateAt)
				VALUES (:kode, :tanggal, :lokasi, :lat, :lng, :gambar, :ket, :info_jalan, :admin_id, NOW(), NOW());
			");
			$add->bindParam(":kode", $data['kode']);
			$add->bindParam(":tanggal", $data['tanggal']);
			$add->bindParam(":lokasi", $data['lokasi']);
			$add->bindParam(":lat", $data['lat']);
			$add->bindParam(":lng", $data['lng']);
			$add->bindParam(":gambar", $data['gambar']);
			$add->bindParam(":ket", $data['keterangan']);
			$add->bindParam(":info_jalan", $data['info_jalan']);
			$add->bindParam(":admin_id", $data['admin_id']);
			$add->execute();
		}

		public function inputToALL($data = array(), $function)
		{
			$this->$function($data, $data['kid']);
			return $this->output('suc','Berhasil diinput');
		}

		private function setPengemudi($data = array(), $laka_id)
		{
			if(!$this->arrayNull($data))
			{
				$add = $this->db->prepare("
					INSERT INTO pengemudi(nama, alamat, umur, no_ktp, no_sim, jenis_sim, jenis_kelamin, info_tambahan, kecelakaan_id)
					VALUES (:nama, :alamat, :umur, :no_ktp, :no_sim, :jenis_sim, :jenis_kelamin, :info_extra, :laka_id);	
				");

				$add->bindParam(":nama", $data['nama']);
				$add->bindParam(":alamat", $data['alamat']);
				$add->bindParam(":umur", $data['umur']);
				$add->bindParam(":no_ktp", $data['no_ktp']);
				$add->bindParam(":no_sim", $data['no_sim']);
				$add->bindParam(":jenis_sim", $data['jenis_sim']);
				$add->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
				$add->bindParam(":info_extra", $data['info_extra']);
				$add->bindParam(":laka_id", $laka_id);
				$add->execute();
			}
		}

		private function setPenumpang($data = array(), $laka_id)
		{
			if(!$this->arrayNull($data))
			{
				$add = $this->db->prepare("
					INSERT INTO penumpang(nama, alamat, umur, no_ktp, info_cedera, jenis_kelamin, info_tambahan, kecelakaan_id)
					VALUES (:nama, :alamat, :umur, :no_ktp, :info_cedera, :jenis_kelamin, :info_extra, :laka_id);
				");

				$add->bindParam(":nama", $data['nama']);
				$add->bindParam(":alamat", $data['alamat']);
				$add->bindParam(":umur", $data['umur']);
				$add->bindParam(":no_ktp", $data['no_ktp']);
				$add->bindParam(":info_cedera", $data['info_cedera']);
				$add->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
				$add->bindParam(":info_extra", $data['info_extra']);
				$add->bindParam(":laka_id", $laka_id);
				$add->execute();
			}
		}

		private function setSaksi($data = array(), $laka_id)
		{
			if(!$this->arrayNull($data))
			{
				$add = $this->db->prepare("
					INSERT INTO saksi(nama, no_ktp, umur, alamat, jenis_kelamin, pernyataan, kecelakaan_id)
					VALUES (:nama, :no_ktp, :umur, :alamat, :jenis_kelamin, :pernyataan, :laka_id);
				");

				$add->bindParam(":nama", $data['nama']);
				$add->bindParam(":no_ktp", $data['no_ktp']);
				$add->bindParam(":umur", $data['umur']);
				$add->bindParam(":alamat", $data['alamat']);
				$add->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
				$add->bindParam(":pernyataan", $data['pernyataan']);
				$add->bindParam(":laka_id", $laka_id);
				$add->execute();
			}
		}

		private function setTersangka($data = array(), $laka_id)
		{
			if(!$this->arrayNull($data))
			{
				$add = $this->db->prepare("
					INSERT INTO tersangka(nama, no_ktp, umur, alamat, jenis_kelamin, pernyataan, kecelakaan_id)
					VALUES (:nama, :no_ktp, :umur, :alamat, :jenis_kelamin, :pernyataan, :laka_id);
				");

				$add->bindParam(":nama", $data['nama']);
				$add->bindParam(":no_ktp", $data['no_ktp']);
				$add->bindParam(":umur", $data['umur']);
				$add->bindParam(":alamat", $data['alamat']);
				$add->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
				$add->bindParam(":pernyataan", $data['pernyataan']);
				$add->bindParam(":laka_id", $laka_id);
				$add->execute();
			}
		}
		
		private function setKorban($data = array(), $laka_id)
		{
			if(!$this->arrayNull($data))
			{
				$add = $this->db->prepare("
					INSERT INTO korban(nama, no_ktp, umur, alamat, jenis_kelamin, pernyataan, status, kecelakaan_id)
					VALUES (:nama, :no_ktp, :umur, :alamat, :jenis_kelamin, :pernyataan, :status, :laka_id);
				");

				$add->bindParam(":nama", $data['nama']);
				$add->bindParam(":no_ktp", $data['no_ktp']);
				$add->bindParam(":umur", $data['umur']);
				$add->bindParam(":alamat", $data['alamat']);
				$add->bindParam(":jenis_kelamin", $data['jenis_kelamin']);
				$add->bindParam(":pernyataan", $data['pernyataan']);
				$add->bindParam(":status", $datap['status']);
				$add->bindParam(":laka_id", $laka_id);
				$add->execute();
			}
		}

		private function arrayNull($data = array())
		{
			foreach ($data as $key => $value) {
				$value = trim($value);
				if(empty($value))
					return true;
				else 
					return false;
			}
		}

		public function totalRow($id, $table)
		{
			$sql = "SELECT * FROM {$table} WHERE kecelakaan_id = {$id}";
			$stat = $this->db->prepare($sql);
			$stat->execute();
			return $stat->rowCount();
		}

		public function showKejadian($jenis)
		{
			$output = array();
			$statement = $this->db->prepare(
			"SELECT * FROM kejadian WHERE id_kasus = {$jenis} order by id desc"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			$i = 0;
			foreach($result as $row)
			{
				$output[$i]['id'] = $row["id"];
				$output[$i]["judul"] = $row["judul"];
				$output[$i]["gambar"] = $row["gambar"];
				$i++;
			}
			echo json_encode($output);
		}

		public function showBerita()
		{
			$output = array();
			$statement = $this->db->prepare(
			"SELECT * FROM berita order by id desc"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			$i = 0;
			foreach($result as $row)
			{
				$output[$i]['id'] = $row["id"];
				$output[$i]["judul"] = $row["judul"];
				$output[$i]["gambar"] = $row["gambar"];
				$i++;
			}
			echo json_encode($output);
		}

		public function total_records($table)
		{
			$statement = $this->db->prepare("SELECT * FROM {$table}");
			$statement->execute();
			$result = $statement->fetchAll();
			return $statement->rowCount();
		}
		
		private function output($msg,$print)
		{
		  $out = array(
			'msg' => $msg,
			'print' => $print
		  );
		  return $out;
		}
	}
?>