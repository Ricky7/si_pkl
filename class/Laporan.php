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

		private function _dataKecelakaan($data = array())
		{
			$sql = 
				"SELECT 
					kode, 
					createAt,
					lokasi,
					qPenumpang.jPenumpang as penumpang, 
					qSaksi.jSaksi as saksi,
					qTersangka.jTersangka as tersangka,
					qKorban.jKorban as korban
				FROM kecelakaan,
				(
					SELECT kecelakaan_id, COUNT(id) as jPenumpang FROM penumpang GROUP BY kecelakaan_id
				) as qPenumpang,
				(
					SELECT kecelakaan_id, COUNT(id) as jSaksi FROM saksi GROUP BY kecelakaan_id
				) as qSaksi,
				(
					SELECT kecelakaan_id, COUNT(id) as jTersangka FROM tersangka GROUP BY kecelakaan_id
				) as qTersangka,
				(
					SELECT kecelakaan_id, COUNT(id) as jKorban FROM korban GROUP BY kecelakaan_id
				) as qKorban
				WHERE  kecelakaan.id = qPenumpang.kecelakaan_id
				AND kecelakaan.id = qSaksi.kecelakaan_id
				AND kecelakaan.id = qTersangka.kecelakaan_id
				AND kecelakaan.id = qKorban.kecelakaan_id";
			$statement = $this->db->prepare($sql);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}

		private function _dataLaporanWarga($data = array())
		{
			$statement = $this->db->prepare(
				"SELECT * FROM laporan a INNER JOIN users b
					ON(a.id_user = b.id)
					WHERE DATE(a.tgl_lapor) 
					BETWEEN '".$data['from']."' AND '".$data['to']."' AND a.jenis_laporan = '".$data['kasus']."'"
			);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}

		public function _laporanKejadian($data = array(), $title = array(), $headData = array(), $titleData = array(), $initial = array())
		{
			$result = $this->kopSurat($headData);
			$result .= $this->headTable($headData);
			$result .= $this->titleTable($titleData);
			$_data = $this->_dataKejadian($data);
			$result .= $this->contentTable($_data, $title);
			$result .= $this->footTable();
			$result .= $this->signPortrait();
			$res = $this->initial($initial, $result);
			return $result;
		}

		public function _laporanKecelakaan($data = array(), $title = array(), $headData = array(), $titleData = array(), $initial = array())
		{
			$result = $this->kopSurat($headData);
			$result .= $this->headTable($headData);
			$result .= $this->titleTable($titleData);
			$_data = $this->_dataKecelakaan($data);
			$result .= $this->contentTable($_data, $title);
			$result .= $this->footTable();
			$result .= $this->signLandscape();
			$res = $this->initial($initial, $result);
			return $result;
		}

		public function _laporanWarga($data = array(), $title = array(), $headData = array(), $titleData = array(), $initial = array())
		{
			$result = $this->kopSurat($headData);
			$result .= $this->headTable($headData);
			$result .= $this->titleTable($titleData);
			$_data = $this->_dataLaporanWarga($data);
			$result .= $this->contentTable($_data, $title);
			$result .= $this->footTable();
			$result .= $this->signPortrait();
			$res = $this->initial($initial, $result);
			return $result;
		}

		private function kopSurat($data = array())
		{
			$head = '<center><img src="../images/icon.png" width="100px" heigth="100px"></center>';
			$head .= '<center><h4 style="padding-bottom:-40px">KEPOLISIAN NEGARA REPULIK INDONESIA</h4></center>';
			$head .= '<center><h4 style="padding-bottom:-40px">DAERAH SUMATERA UTARA</h4></center>';
			$head .= '<center><h4 style="padding-bottom:-40px">RESOR SIMALUNGUN</h4></center>';
			$head .= '<center><h5 style="padding-bottom:-40px"><u>Jalan Jon Horailam Saragih No. 110 P. Raya 21162</u></h5></center>';
			$head .= '<center><h5>Perihal : '.$data['title'].'</h5></center>';
			return $head;
		}

		private function signPortrait()
        {   $sign = '<div style="padding-top:30px">';
            $sign .= '<div style="padding-left:480px"><span>Dikeluarkan di :    Pematangraya</span></div>';
            $sign .= '<div style="padding-left:480px"><span>Pada Tanggal    :    '.date("d M Y").'</span></div>';
            $sign .= '<div style="padding-left:480px"><hr></div>';
            $sign .= '<div style="padding-left:495px"><h5>KEPALA UNIT KECELAKAAN</h5></div>';
            $sign .= '<div style="padding-left:480px;padding-top:50px"><hr></div>';
            $sign .= '<div style="padding-left:525px;padding-top:-25px"><h5>INSPEKTUR POLISI</h5></div>';
            $sign .= '</div>';
            return $sign;
		}
		
		private function signLandscape()
        {   $sign = '<div style="padding-top:30px">';
            $sign .= '<div style="padding-left:800px"><span>Dikeluarkan di :    Pematangraya</span></div>';
            $sign .= '<div style="padding-left:800px"><span>Pada Tanggal    :    '.date("d M Y").'</span></div>';
            $sign .= '<div style="padding-left:800px"><hr></div>';
            $sign .= '<div style="padding-left:820px"><h5>KEPALA UNIT KECELAKAAN</h5></div>';
            $sign .= '<div style="padding-left:800px;padding-top:50px"><hr></div>';
            $sign .= '<div style="padding-left:850px;padding-top:-25px"><h5>INSPEKTUR POLISI</h5></div>';
            $sign .= '</div>';
            return $sign;
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