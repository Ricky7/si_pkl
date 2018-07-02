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