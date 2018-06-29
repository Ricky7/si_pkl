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
				$output["judul"] = $row["judul"];
				$output["isi"] = $row["isi"];
				$output["alamat"] = $row["alamat"];
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