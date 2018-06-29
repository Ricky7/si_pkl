<?php
	/*
		handle semua laporan user
	*/
	class Laporan {
		
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
					INSERT INTO laporan(judul, jenis_laporan, lokasi, isi, gambar, tgl_lapor, id_user) 
					VALUES(:judul, :jenis, :lokasi, :isi, :gambar, NOW(), :user)
					");
				  $query->bindParam(":judul", $data['judul']);
				  $query->bindParam(":jenis", $data['jenis']);
				  $query->bindParam(":lokasi", $data['lokasi']);
				  $query->bindParam(":isi", $data['isi']);
				  $query->bindParam(":gambar", $data['gambar']);
				  $query->bindParam(":user", $data['user_id']);
				  $query->execute();

				  return $this->output('suc','Berhasil Melapor');
			  }catch(PDOException $e){
				  // Jika terjadi error
				  return $this->output('err',$e->getMessage());
			  }
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