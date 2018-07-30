<?php
  /**
   * to handle all user
   */
  class User
  {

    private $db;
    private $error;

    function __construct($db_conn)
    {
      $this->db = $db_conn;

      if(!isset($_SESSION)){
          session_start();
      }
    }

    public function Login($data = array())
    {
      try
      {
          // Ambil data dari database
          $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
          $query->bindParam(":username", $data['username']);
          $query->execute();
          $res = $query->fetch();

          // Jika jumlah baris > 0
          if($query->rowCount() > 0){
              // jika password yang dimasukkan sesuai dengan yg ada di database
              if(password_verify($data['password'], $res['password'])){
                  $_SESSION['user_session'] = $res['id'];
                  $_SESSION['user_nama'] = $res['nama'];
                  return $this->output('suc','Berhasil Login');
              }else{
                  return $this->output('err','Username atau Password Salah');
              }
          }else{
              return $this->output('err','Anda Belum Terdaftar');
          }
      } catch (PDOException $e) {
          return $this->output('err', $e->getMessage());
      }
    }

    public function register($data = array())
    {
      try
      {
          // buat hash dari password yang dimasukkan
          $hashPasswd = password_hash($data['password'], PASSWORD_DEFAULT);

          //Masukkan user baru ke database
          $query = $this->db->prepare("INSERT INTO users(nama, username, password, tgl_create) VALUES(:nama, :username, :pass, NOW())");
          $query->bindParam(":nama", $data['nama']);
          $query->bindParam(":username", $data['username']);
          $query->bindParam(":pass", $hashPasswd);
          $query->execute();

          return $this->output('suc','Registrasi Berhasil');
      }catch(PDOException $e){
          // Jika terjadi error
          return $this->output('err',$e->getMessage());
      }
    }

    public function getUser()
    {
      if(!$this->isLog()){
        header('location: index.php?error');
        return false;
      }

      try {
          // Ambil data user dari database
          $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
          $query->bindParam(":id", $_SESSION['user_session']);
          $query->execute();
          return $query->fetch();
      } catch (PDOException $e) {
          echo $e->getMessage();
          return false;
      }

    }

    public function isLog()
    {
      if(isset($_SESSION['user_session']))
	  {
	        return true;
	  }
    }
	
	public function logout(){
		// Hapus session
		session_destroy();
		// Hapus user_session
		unset($_SESSION['user_session']);
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
