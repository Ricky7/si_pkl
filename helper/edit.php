<?php 
	require_once "../db_connect.php";
	require_once "../class/User.php";
	require_once "../class/Laporan.php";
	require_once "../class/Event.php";
	require_once "../class/Admin.php";
	
	if($_POST["operation"] == "edit" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$data = array(
			'id' => $_POST['id'],
			'isi' => $_POST['isi_kejadian']
		);
		$res = $event->updateKejadian($data);
		echo json_encode($res);
	}
	
	if($_POST["operation"] == "edit" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$data = array(
			'id' => $_POST['id'],
			'isi' => $_POST['isi_berita']
		);
		$res = $event->updateBerita($data);
		echo json_encode($res);
	}

	if($_POST["operation"] == "edit" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$imgFile = $_FILES['gambar']['name'];
		$tmp_dir = $_FILES['gambar']['tmp_name'];
		$imgSize = $_FILES['gambar']['size'];


		if(empty($imgFile)) {
			$errMsg = "File gambar belum dipilih..";
			$userpic = '';
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
			'id' => $_POST['id'],
			'tanggal' => $_POST['tgl'],
			'lokasi' => $_POST['addr'],
			'lat' => $_POST['lat'],
			'lng' => $_POST['long'],
			'gambar' => $userpic,
			'keterangan' => $_POST['ket_kecelakaan'],
			'info_jalan' => $_POST['info_jalan'],
			'status' => $_POST['status']
		);
		$res = $event->updateKecelakaan($data);
		echo json_encode($res);
	}

	if($_POST["operation"] == "edit" && $_POST["table"] == "approve"){
		$event = new Event($db);
		$data = array(
			'id' => $_POST['id'],
			'status' => $_POST['status']
		);
		$res = $event->approveKecelakaan($data);
		echo json_encode($res);
	}
?>