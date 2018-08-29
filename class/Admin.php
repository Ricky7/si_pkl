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
					  $_SESSION['adminRole'] = $res['role'];
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

		public function addPolisi($data = array())
		{
			$hashPasswd = password_hash('123456', PASSWORD_DEFAULT);
			
			$add = $this->db->prepare("
				INSERT INTO admin(username, password, nama, role)
				VALUES (:username, :password, :nama, :role);
			");
			$add->bindParam(":username", $data['username']);
			$add->bindParam(":password", $hashPasswd);
			$add->bindParam(":nama", $data['nama']);
			$add->bindParam(":role", $data['role']);
			if($add->execute()) {
				return $this->output('suc','Berhasil');
			} else {
				return $this->output('err', 'Gagal');
			}
		}

		public function updatePolisi($data = array())
		{
			try {
				$sql = $this->db->prepare(
					"UPDATE admin SET password = :pass WHERE id = :id"
				);
				$sql->bindparam(':pass', $data['password']);      
			    $sql->bindparam(':id', $data['id']);
			    $sql->execute();
				
				return $this->output('suc', 'Berhasil Diupdate');
			}catch(PDOException $e){
				return $this->output('err', $e->getMessage());
			}
		}

		public function delPolisi($id)
		{
			try {
				$statement = $this->db->prepare(
					"DELETE FROM admin WHERE id = :id"
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