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
?>