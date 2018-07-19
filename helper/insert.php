<?php
  require_once "../db_connect.php";
  require_once "../class/User.php";
  require_once "../class/Laporan.php";
  require_once "../class/Event.php";
  require_once "../class/Admin.php";
  
  if(isset($_POST["operation"]) && isset($_POST["table"])){
	
	/*
		Registrasi User
	*/
	if($_POST["operation"] == "add" && $_POST["table"] == "user"){
		$user = new User($db);
		$data = array(
			'nama' => $_POST['reg_nama'],
			'username' => $_POST['reg_username'],
			'password' => $_POST['reg_password']
		);
		$res = $user->register($data);
		echo json_encode($res);
	}
	
	/*
		Lapor Kejadian
	*/
	if($_POST["operation"] == "add" && $_POST["table"] == "laporan"){
		$laporan = new Laporan($db);
		$user = new User($db);
		
		$imgFile = $_FILES['gambar']['name'];
		$tmp_dir = $_FILES['gambar']['tmp_name'];
		$imgSize = $_FILES['gambar']['size'];


		if(empty($imgFile)) {
			$errMsg = "File gambar belum dipilih..";
		} else {
			$upload_dir = '../gambar/'; // upload directory
	 
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		  
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		  
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){   
				// Check file size '5MB'
				if($imgSize < 5000000)    {
				  move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				} else {
				  $errMSG = "Maaf, ukuran file anda terlalu besar.";
				}
			} else {
				$errMSG = "Maaf, hanya ekstensi JPG, JPEG, PNG & GIF yang diterima.";  
			}
		}
		
		$jenis = $_POST['jenis'];
		switch($jenis){
			case 1: $jenis_laporan = 'kejadian'; break;
			case 2: $jenis_laporan = 'kerusakan'; break;
		}
		
		$data = array(
			'judul' => $_POST['judul'],
			'jenis' => $jenis_laporan,
			'gambar' => $userpic,
			'lokasi' => $_POST['lokasi'],
			'isi' => $_POST['isi'],
			'user_id' => $_SESSION['user_session']
		);
		
		$res = $laporan->insertLaporan($data);
		echo json_encode($res);
	}
	
	/*
	* admin
	* Input Kejadian
	*/
	if($_POST["operation"] == "add" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$admin = new Admin($db);
		
		$imgFile = $_FILES['gambar']['name'];
		$tmp_dir = $_FILES['gambar']['tmp_name'];
		$imgSize = $_FILES['gambar']['size'];


		if(empty($imgFile)) {
			$errMsg = "File gambar belum dipilih..";
		} else {
			$upload_dir = '../gambar/'; // upload directory
	 
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		  
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		  
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){   
				// Check file size '5MB'
				if($imgSize < 5000000)    {
				  move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				} else {
				  $errMSG = "Maaf, ukuran file anda terlalu besar.";
				}
			} else {
				$errMSG = "Maaf, hanya ekstensi JPG, JPEG, PNG & GIF yang diterima.";  
			}
		}
		
		$data = array(
			'judul' => $_POST['judul'],
			'gambar' => $userpic,
			'lat' => $_POST['lat'],
			'long' => $_POST['long'],
			'addr' => $_POST['addr'],
			'isi' => $_POST['isi_kejadian'],
			'kasus' => $_POST['kasus'],
			'admin' => $_SESSION['admin_session']
		);
		
		$res = $event->insertKejadian($data);
		echo json_encode($res);
	}
	
	/*
	* admin
	* Input Berita
	*/
	if($_POST["operation"] == "add" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$admin = new Admin($db);
		
		$imgFile = $_FILES['gambar']['name'];
		$tmp_dir = $_FILES['gambar']['tmp_name'];
		$imgSize = $_FILES['gambar']['size'];


		if(empty($imgFile)) {
			$errMsg = "File gambar belum dipilih..";
		} else {
			$upload_dir = '../gambar/'; // upload directory
	 
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		  
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		  
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){   
				// Check file size '5MB'
				if($imgSize < 5000000)    {
				  move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				} else {
				  $errMSG = "Maaf, ukuran file anda terlalu besar.";
				}
			} else {
				$errMSG = "Maaf, hanya ekstensi JPG, JPEG, PNG & GIF yang diterima.";  
			}
		}
		
		$data = array(
			'judul' => $_POST['judul'],
			'gambar' => $userpic,
			'isi' => $_POST['isi_berita'],
			'admin' => $_SESSION['admin_session']
		);
		
		$res = $event->insertBerita($data);
		echo json_encode($res);
	}

	/*
	* admin
	* Input Kecelakaan
	*/
	if($_POST["operation"] == "add" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$admin = new Admin($db);
		
		$imgFile = $_FILES['gambar']['name'];
		$tmp_dir = $_FILES['gambar']['tmp_name'];
		$imgSize = $_FILES['gambar']['size'];


		if(empty($imgFile)) {
			$errMsg = "File gambar belum dipilih..";
		} else {
			$upload_dir = '../gambar/'; // upload directory
	 
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		  
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		  
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;

			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){   
				// Check file size '5MB'
				if($imgSize < 5000000)    {
				  move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				} else {
				  $errMSG = "Maaf, ukuran file anda terlalu besar.";
				}
			} else {
				$errMSG = "Maaf, hanya ekstensi JPG, JPEG, PNG & GIF yang diterima.";  
			}
		}

		$data_laka = array(
			'kode' => $_POST['kode'],
			'tanggal' => $_POST['tgl'],
			'lokasi' => $_POST['addr'],
			'lat' => $_POST['lat'],
			'lng' => $_POST['long'],
			'gambar' => $userpic,
			'keterangan' => $_POST['ket_kecelakaan'],
			'info_jalan' => $_POST['info_jalan'],
			'admin_id' =>  $_SESSION['admin_session']
		);

		$data_pengemudi = array(
			'nama' => $_POST['nama_pengemudi'],
			'alamat' => $_POST['alamat_pengemudi'],
			'umur' => $_POST['umur_pengemudi'],
			'no_ktp' => $_POST['ktp_pengemudi'],
			'no_sim' => $_POST['sim_pengemudi'],
			'jenis_sim' => $_POST['jensim_pengemudi'],
			'jenis_kelamin' => $_POST['gender_pengemudi'],
			'info_extra' => $_POST['ket_pengemudi']
		);

		$data_penumpang = array(
			'nama' => $_POST['nama_penumpang'],
			'alamat' => $_POST['alamat_penumpang'],
			'umur' => $_POST['umur_penumpang'],
			'no_ktp' => $_POST['ktp_penumpang'],
			'info_cedera' => $_POST['info_cedera_penumpang'],
			'jenis_kelamin' => $_POST['gender_penumpang'],
			'info_extra' => $_POST['ket_penumpang']
		);

		$data_saksi = array(
			'nama' => $_POST['nama_saksi'],
			'no_ktp' => $_POST['ktp_saksi'],
			'umur' => $_POST['umur_saksi'],
			'alamat' => $_POST['alamat_saksi'],
			'jenis_kelamin' => $_POST['gender_saksi'],
			'pernyataan' => $_POST['pernyataan_saksi']
		);

		$data_tersangka = array(
			'nama' => $_POST['nama_tersangka'],
			'no_ktp' => $_POST['ktp_tersangka'],
			'umur' => $_POST['umur_tersangka'],
			'alamat' => $_POST['alamat_tersangka'],
			'jenis_kelamin' => $_POST['gender_tersangka'],
			'pernyataan' => $_POST['pernyataan_tersangka']
		);

		$data_korban = array(
			'nama' => $_POST['nama_korban'],
			'no_ktp' => $_POST['ktp_korban'],
			'umur' => $_POST['umur_korban'],
			'alamat' => $_POST['alamat_korban'],
			'jenis_kelamin' => $_POST['gender_korban'],
			'pernyataan' => $_POST['pernyataan_korban'],
			'status' => $_POST['status_korban']
		);
		
		$res = $event->insertKecelakaan($data_laka, $data_pengemudi, $data_penumpang, $data_saksi, $data_tersangka, $data_korban);
		echo json_encode($res);
	}

	if($_POST["operation"] == "add" && $_POST["table"] == "pengemudi"){
		$event = new Event($db);
		$admin = new Admin($db);

		$data = array(
			'nama' => $_POST['nama_pengemudi'],
			'alamat' => $_POST['alamat_pengemudi'],
			'umur' => $_POST['umur_pengemudi'],
			'no_ktp' => $_POST['ktp_pengemudi'],
			'no_sim' => $_POST['sim_pengemudi'],
			'jenis_sim' => $_POST['jensim_pengemudi'],
			'jenis_kelamin' => $_POST['gender_pengemudi'],
			'info_extra' => $_POST['ket_pengemudi'],
			'kid' => $_POST['k_id']
		);

		$res = $event->inputToALL($data,'setPengemudi');
		echo json_encode($res);
	}

	if($_POST["operation"] == "add" && $_POST["table"] == "penumpang"){
		$event = new Event($db);
		$admin = new Admin($db);

		$data = array(
			'nama' => $_POST['nama_penumpang'],
			'alamat' => $_POST['alamat_penumpang'],
			'umur' => $_POST['umur_penumpang'],
			'no_ktp' => $_POST['ktp_penumpang'],
			'info_cedera' => $_POST['info_cedera_penumpang'],
			'jenis_kelamin' => $_POST['gender_penumpang'],
			'info_extra' => $_POST['ket_penumpang'],
			'kid' => $_POST['k_id']
		);

		$res = $event->inputToALL($data,'setPenumpang');
		echo json_encode($res);
	}

	if($_POST["operation"] == "add" && $_POST["table"] == "saksi"){
		$event = new Event($db);
		$admin = new Admin($db);

		$data = array(
			'nama' => $_POST['nama_saksi'],
			'no_ktp' => $_POST['ktp_saksi'],
			'umur' => $_POST['umur_saksi'],
			'alamat' => $_POST['alamat_saksi'],
			'jenis_kelamin' => $_POST['gender_saksi'],
			'pernyataan' => $_POST['pernyataan_saksi'],
			'kid' => $_POST['k_id']
		);

		$res = $event->inputToALL($data,'setSaksi');
		echo json_encode($res);
	}

	if($_POST["operation"] == "add" && $_POST["table"] == "tersangka"){
		$event = new Event($db);
		$admin = new Admin($db);

		$data = array(
			'nama' => $_POST['nama_tersangka'],
			'no_ktp' => $_POST['ktp_tersangka'],
			'umur' => $_POST['umur_tersangka'],
			'alamat' => $_POST['alamat_tersangka'],
			'jenis_kelamin' => $_POST['gender_tersangka'],
			'pernyataan' => $_POST['pernyataan_tersangka'],
			'kid' => $_POST['k_id']
		);

		$res = $event->inputToALL($data,'setTersangka');
		echo json_encode($res);
	}

	if($_POST["operation"] == "add" && $_POST["table"] == "korban"){
		$event = new Event($db);
		$admin = new Admin($db);

		$data = array(
			'nama' => $_POST['nama_korban'],
			'no_ktp' => $_POST['ktp_korban'],
			'umur' => $_POST['umur_korban'],
			'alamat' => $_POST['alamat_korban'],
			'jenis_kelamin' => $_POST['gender_korban'],
			'pernyataan' => $_POST['pernyataan_korban'],
			'status' => $_POST['status_korban'],
			'kid' => $_POST['k_id']
		);

		$res = $event->inputToALL($data,'setKorban');
		echo json_encode($res);
	}
  }
?>
