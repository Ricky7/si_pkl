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
			'kasus' => 1,
			'admin' => $_SESSION['admin_session']
		);
		
		$res = $event->insertKejadian($data);
		echo json_encode($res);
	}

  }
?>
