<?php 
	require_once "../db_connect.php";
	require_once "../class/User.php";
	require_once "../class/Laporan.php";
	require_once "../class/Event.php";
	require_once "../class/Admin.php";
	
	if($_POST["operation"] == "delete" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$result = $event->delKejadian($_POST['id']);
		echo json_encode($result);
	}
	
	if($_POST["operation"] == "delete" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$result = $event->delBerita($_POST['id']);
		echo json_encode($result);
	}
	
	if($_POST["operation"] == "delete" && $_POST["table"] == "laporan"){
		$event = new Event($db);
		$result = $event->delLaporan($_POST['id']);
		echo json_encode($result);
	}
	
	if($_POST["operation"] == "delete" && $_POST["table"] == "pengemudi"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "penumpang"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "saksi"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "tersangka"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "korban"){
		$event = new Event($db);
		$result = $event->delData($_POST['id'],$_POST["table"]);
		echo json_encode($result);
	}

	if($_POST["operation"] == "delete" && $_POST["table"] == "polisi"){
		$admin = new Admin($db);
		$result = $admin->delPolisi($_POST['id']);
		echo json_encode($result);
	}
?>