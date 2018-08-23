<?php
	/*
		handle semua laporan user
	*/
	require_once '../library/Pdf.php';

	class Laporan extends Pdf {
		
		private $db;
		private $error;

		function __construct($db_conn)
		{
			$this->db = $db_conn;
			date_default_timezone_set('Asia/Jakarta');
		}
		
		public function insertLaporan($data = array())
		{
			try
			  {
				  //Masukkan user baru ke database
				  $query = $this->db->prepare("
					INSERT INTO laporan(judul, jenis_laporan, lokasi, isi, gambar, tgl_lapor, id_user, video) 
					VALUES(:judul, :jenis, :lokasi, :isi, :gambar, NOW(), :user, :video)
					");
				  $query->bindParam(":judul", $data['judul']);
				  $query->bindParam(":jenis", $data['jenis']);
				  $query->bindParam(":lokasi", $data['lokasi']);
				  $query->bindParam(":isi", $data['isi']);
					$query->bindParam(":gambar", $data['gambar']);
					$query->bindParam(":video", $data['video']);
				  $query->bindParam(":user", $data['user_id']);
				  $query->execute();

				  return $this->output('suc','Berhasil Melapor');
			  }catch(PDOException $e){
				  // Jika terjadi error
				  return $this->output('err',$e->getMessage());
			  }
		}

		public function getDataLaporan()
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT DATE_FORMAT(tgl_lapor,'%d %M %Y') AS dates, 
					COUNT(id) as jlh
				FROM laporan GROUP BY dates LIMIT 7"
			);
			$statement->execute();
			$output = $statement->fetchAll();
			
		  echo json_encode($output);
		}

		public function getDataKejadian()
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT DATE_FORMAT(tgl_buat,'%d %M %Y') AS dates, 
					COUNT(id) as jlh
				FROM kejadian WHERE id_kasus = 1 GROUP BY dates LIMIT 7"
			);
			$statement->execute();
			$output = $statement->fetchAll();
			
		  echo json_encode($output);
		}

		public function getDataKerusakan()
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT DATE_FORMAT(tgl_buat,'%d %M %Y') AS dates, 
					COUNT(id) as jlh
				FROM kejadian WHERE id_kasus = 2 GROUP BY dates LIMIT 7"
			);
			$statement->execute();
			$output = $statement->fetchAll();
			
		  echo json_encode($output);
		}

		public function getDataKecelakaan()
		{
			$output = array();
			$statement = $this->db->prepare(
				"SELECT DATE_FORMAT(tanggal,'%d %M %Y') AS dates, 
					COUNT(id) as jlh
				FROM kecelakaan GROUP BY dates LIMIT 7"
			);
			$statement->execute();
			$output = $statement->fetchAll();
			
		  echo json_encode($output);
		}

		private function _dataKejadian($data = array())
		{
			$statement = $this->db->prepare(
				"SELECT *, a.id as ids FROM kejadian a INNER JOIN kasus b 
					ON (b.id = a.id_kasus) 
					WHERE DATE(a.tgl_buat) 
					BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.id_kasus = '".$data['kasus']."'"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}

		public function _laporan($data = array(), $title = array(), $headData = array(), $titleData = array(), $initial = array())
		{
			$result = $this->headTable($headData);
			$result .= $this->titleTable($titleData);
			$_data = $this->_dataKejadian($data);
			$result .= $this->contentTable($_data, $title);
			$result .= $this->footTable();
			$res = $this->initial($initial, $result);
			
			// $result = $this->_dataKejadian($data);
			return $result;
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