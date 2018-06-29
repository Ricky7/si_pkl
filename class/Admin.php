<?php
	class Admin{
		
		private $db;
		private $error;

		function __construct($db_conn)
		{
			$this->db = $db_conn;

			if(!isset($_SESSION))
			{
				session_start();
			}
		}
		
		public function Login($data = array())
		{
		  try
		  {
			  // Ambil data dari database
			  $query = $this->db->prepare("SELECT * FROM admin WHERE username = :username");
			  $query->bindParam(":username", $data['username']);
			  $query->execute();
			  $res = $query->fetch();

			  // Jika jumlah baris > 0
			  if($query->rowCount() > 0){
				  // jika password yang dimasukkan sesuai dengan yg ada di database
				  if(password_verify($data['password'], $res['password'])){
					  $_SESSION['admin_session'] = $res['id'];
					  $_SESSION['admin_nama'] = $res['nama'];
					  $_SESSION['isAdminLog'] = TRUE;
					  return $this->output('suc','Berhasil Login');
				  }else{
					  return $this->output('err','Username atau Password Salah');
				  }
			  }else{
				  return $this->output('err','Anda Belum Terdaftar');
			  }
		  } catch (PDOException $e) {
			  return $this->output('err',getMessage());
		  }
		}
		
		public function isLog()
		{
			if(isset($_SESSION['admin_session']))
			{
				return true;
			}
		}
		
		public function logout()
		{
			// Hapus session
			session_destroy();
			// Hapus user_session
			unset($_SESSION['admin_session']);
			return true;
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