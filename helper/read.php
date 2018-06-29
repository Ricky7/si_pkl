<?php
  require_once "../db_connect.php";
  require_once "../class/User.php";
  require_once "../class/Admin.php";
  require_once "../class/Event.php";

  if(isset($_POST["operation"]) && isset($_POST["table"])){
	
	if($_POST["operation"] == "read" && $_POST["table"] == "user"){
		$user = new User($db);
		$data = array(
			'username' => $_POST['log_username'],
			'password' => $_POST['log_password']
		);
		$res = $user->login($data);
		echo json_encode($res);
	}
	
	if($_POST["operation"] == "read" && $_POST["table"] == "admin"){
		$admin = new Admin($db);
		$data = array(
			'username' => $_POST['log_username'],
			'password' => $_POST['log_password']
		);
		$res = $admin->login($data);
		echo json_encode($res);
	}
	
	if($_POST["operation"] == "readOne" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$result = $event->fetchKejadian($_POST['id']);
		echo json_encode($result);
	}
	
	if($_POST["operation"] == "read" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idK, a.judul, c.nama_kasus, a.tgl_buat, a.alamat  
					FROM kejadian a INNER JOIN kasus c 
					ON (c.id = a.id_kasus) ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'WHERE a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY a.id DESC ';
		}
		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$statement = $db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		$num = 1;
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $num;
			$sub_array[] = $row['judul'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['nama_kasus'];
			$sub_array[] = $row['tgl_buat'];
			$sub_array[] = '
				<button type="button" name="edit" id="'.$row["idK"].'" class="btn btn-primary btn-sm edit">Edit</button>
				<button type="button" name="delete" id="'.$row["idK"].'" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records($_POST['table']),
			"data"				=>	$data
		);
		echo json_encode($output);

	}
  }
?>
