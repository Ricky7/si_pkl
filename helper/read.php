<?php
	require_once "../db_connect.php";
	require_once "../class/User.php";
	require_once "../class/Admin.php";
	require_once "../class/Event.php";
	require_once "../class/Laporan.php";
	require_once "../vendor/autoload.php";
  
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$event->fetchKejadian($_POST['id']);
	}
	
	if($_POST["operation"] == "readOne" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$event->fetchKecelakaan($_POST['id']);
	}

	if($_POST["operation"] == "read" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idK, a.judul, c.nama_kasus, a.tgl_buat, a.alamat  
					FROM kejadian a INNER JOIN kasus c 
					ON (c.id = a.id_kasus) WHERE a.id_kasus = 1 ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
	
	if($_POST["operation"] == "read" && $_POST["table"] == "kerusakan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idK, a.judul, c.nama_kasus, a.tgl_buat, a.alamat  
					FROM kejadian a INNER JOIN kasus c 
					ON (c.id = a.id_kasus)  WHERE a.id_kasus = 2 ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			"recordsFiltered"	=>	$event->total_records('kejadian'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "read" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idB,a.judul, a.tgl_buat, b.nama 
					FROM berita a INNER JOIN admin b ON (b.id = a.id_admin) ";
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
			$sub_array[] = $row['tgl_buat'];
			$sub_array[] = $row['nama'];
			$sub_array[] = '
				<button type="button" name="edit" id="'.$row["idB"].'" class="btn btn-primary btn-sm edit">Edit</button>
				<button type="button" name="delete" id="'.$row["idB"].'" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('kejadian'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	// data penumpang
	if($_POST["operation"] == "read" && $_POST["table"] == "penumpang"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT id, nama, alamat, umur, no_ktp, jenis_kelamin
					FROM penumpang WHERE kecelakaan_id = '".$_POST['kecelakaan_id']."' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND nama LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY id DESC ';
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
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['umur'];
			$sub_array[] = $row['no_ktp'];
			$sub_array[] = $row['jenis_kelamin'];
			$sub_array[] = '
				<button type="button" name="delete" id="'.$row["id"].'" data-table="penumpang" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('penumpang'),
			"data"				=>	$data
		);
		echo json_encode($output);
	} 
	
	// data pengemudi
	if($_POST["operation"] == "read" && $_POST["table"] == "pengemudi"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT id, nama, alamat, umur, no_ktp, no_sim, jenis_sim, jenis_kelamin
					FROM pengemudi WHERE kecelakaan_id = '".$_POST['kecelakaan_id']."' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND nama LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY id DESC ';
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
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['umur'];
			$sub_array[] = $row['no_ktp'];
			$sub_array[] = $row['jenis_sim'];
			$sub_array[] = $row['no_sim'];
			$sub_array[] = $row['jenis_kelamin'];
			$sub_array[] = '
				<button type="button" name="delete" id="'.$row["id"].'" data-table="pengemudi" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('pengemudi'),
			"data"				=>	$data
		);
		echo json_encode($output);
	} 

	// data saksi
	if($_POST["operation"] == "read" && $_POST["table"] == "saksi"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT id, nama, alamat, umur, no_ktp, jenis_kelamin
					FROM saksi WHERE kecelakaan_id = '".$_POST['kecelakaan_id']."' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND nama LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY id DESC ';
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
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['umur'];
			$sub_array[] = $row['no_ktp'];
			$sub_array[] = $row['jenis_kelamin'];
			$sub_array[] = '
				<button type="button" name="delete" id="'.$row["id"].'" data-table="saksi" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('saksi'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	// data tersangka
	if($_POST["operation"] == "read" && $_POST["table"] == "tersangka"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT id, nama, alamat, umur, no_ktp, jenis_kelamin
					FROM tersangka WHERE kecelakaan_id = '".$_POST['kecelakaan_id']."' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND nama LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY id DESC ';
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
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['umur'];
			$sub_array[] = $row['no_ktp'];
			$sub_array[] = $row['jenis_kelamin'];
			$sub_array[] = '
				<button type="button" name="delete" id="'.$row["id"].'" data-table="tersangka" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('tersangka'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	// data korban
	if($_POST["operation"] == "read" && $_POST["table"] == "korban"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT id, nama, alamat, umur, no_ktp, jenis_kelamin, status
					FROM korban WHERE kecelakaan_id = '".$_POST['kecelakaan_id']."' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND nama LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY id DESC ';
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
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['alamat'];
			$sub_array[] = $row['umur'];
			$sub_array[] = $row['no_ktp'];
			$sub_array[] = $row['jenis_kelamin'];
			$sub_array[] = $row['status'];
			$sub_array[] = '
				<button type="button" name="delete" id="'.$row["id"].'" data-table="korban" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('korban'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "readOne" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$event->fetchBerita($_POST['id']);
	}
	
	if($_POST["operation"] == "read" && $_POST["table"] == "laporKejadian"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idL, a.judul, a.jenis_laporan, a.lokasi, a.tgl_lapor, b.nama 
					FROM laporan a INNER JOIN users b ON (b.id = a.id_user) WHERE a.jenis_laporan = 'kejadian' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['jenis_laporan'];
			$sub_array[] = $row['lokasi'];
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['tgl_lapor'];
			$sub_array[] = '
				<button type="button" name="view" id="'.$row["idL"].'" class="btn btn-primary btn-sm view">View</button>
				<button type="button" name="delete" id="'.$row["idL"].'" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('laporan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "read" && $_POST["table"] == "laporKerusakan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as idL,a.judul, a.jenis_laporan, a.lokasi, a.tgl_lapor, b.nama 
					FROM laporan a INNER JOIN users b ON (b.id = a.id_user) WHERE a.jenis_laporan = 'kerusakan' ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['jenis_laporan'];
			$sub_array[] = $row['lokasi'];
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['tgl_lapor'];
			$sub_array[] = '
				<button type="button" name="view" id="'.$row["idL"].'" class="btn btn-primary btn-sm view">View</button>
				<button type="button" name="delete" id="'.$row["idL"].'" class="btn btn-danger btn-sm delete">Delete</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('laporan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "readOne" && $_POST["table"] == "laporan"){
		$event = new Event($db);
		$event->fetchLaporan($_POST['id']);
	}
	
	// report kejadian
	if($_POST["operation"] == "readByDate" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= 'SELECT a.id as idK, a.judul, c.nama_kasus, a.tgl_buat, a.alamat  
					FROM kejadian a INNER JOIN kasus c 
					ON (c.id = a.id_kasus) WHERE DATE(a.tgl_buat) BETWEEN "'.$_POST['frm'].'" AND "'.$_POST['to'].'" AND a.id_kasus = 1 ';
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('kejadian'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	// report kerusakan
	if($_POST["operation"] == "readByDate" && $_POST["table"] == "kerusakan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= 'SELECT a.id as idK, a.judul, c.nama_kasus, a.tgl_buat, a.alamat  
					FROM kejadian a INNER JOIN kasus c 
					ON (c.id = a.id_kasus) WHERE DATE(a.tgl_buat) BETWEEN "'.$_POST['frm'].'" AND "'.$_POST['to'].'" AND a.id_kasus = 2 ';
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('kejadian'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	// report kecelakaan
	if($_POST["operation"] == "readByDate" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= 'SELECT a.id, a.kode, DATE(a.tanggal) as tgl 
					FROM kecelakaan a WHERE DATE(a.createAt) BETWEEN "'.$_POST['frm'].'" AND "'.$_POST['to'].'" ';
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.kode LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['kode'];
			$sub_array[] = $row['tgl'];
			$sub_array[] = $event->totalRow($row['id'], 'penumpang');
			$sub_array[] = $event->totalRow($row['id'], 'saksi');
			$sub_array[] = $event->totalRow($row['id'], 'tersangka');
			$sub_array[] = $event->totalRow($row['id'], 'korban');
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('kecelakaan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "readByDate" && $_POST["table"] == "lapKerusakan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= 'SELECT a.id as idL,  a.judul, a.jenis_laporan, a.lokasi, a.tgl_lapor, b.nama 
					FROM laporan a INNER JOIN users b ON (b.id = a.id_user) WHERE DATE(a.tgl_lapor) BETWEEN "'.$_POST['frm'].'" AND "'.$_POST['to'].'" AND a.jenis_laporan = "kerusakan" ';
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['lokasi'];
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['tgl_lapor'];
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('laporan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	if($_POST["operation"] == "readByDate" && $_POST["table"] == "lapKejadian"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= 'SELECT a.id as idL,a.judul, a.jenis_laporan, a.lokasi, a.tgl_lapor, b.nama 
					FROM laporan a INNER JOIN users b ON (b.id = a.id_user) WHERE DATE(a.tgl_lapor) BETWEEN "'.$_POST['frm'].'" AND "'.$_POST['to'].'" AND a.jenis_laporan = "kejadian" ';
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'AND a.judul LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['lokasi'];
			$sub_array[] = $row['nama'];
			$sub_array[] = $row['tgl_lapor'];
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('laporan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
	
	// export kejadian
	if($_POST["operation"] == "export" && $_POST["table"] == "kejadian"){
		
		$event = new Event($db);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'SISTEM INFORMASI PENGADUAN');
		$sheet->mergeCells('A2:C2');
		$sheet->setCellValue('A4', 'Periode');
		$sheet->setCellValue('B4', 'Judul');
		$sheet->setCellValue('A5', $_POST['frm']." - ".$_POST['to']);
		$sheet->setCellValue('B5', 'Laporan Kejadian');
		$sheet->mergeCells('B5:C5');
		
		//header
		$sheet->setCellValue('A7', 'Judul');
		$sheet->setCellValue('B7', 'Lokasi');
		$sheet->setCellValue('C7', 'Kasus');
		$sheet->setCellValue('D7', 'Tanggal');
		
		$arr = array(
			'from' => $_POST['frm'],
			'to' => $_POST['to'],
			'kasus' => 1
		);
		
		$data = $event->exportKejadian($arr);
		
		$no = 1;
		$num_row = 8;
		foreach ($data as $row) {
		  $sheet->setCellValue('A'.$num_row, $row['judul']);
		  $sheet->setCellValue('B'.$num_row, $row['lokasi']);
		  $sheet->setCellValue('C'.$num_row, $row['kasus']);
		  $sheet->setCellValue('D'.$num_row, $row['tanggal']);
		  $no++;
		  $num_row++;
		}
		
		$sheet->getColumnDimension('A')->setWidth(60);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(10);
		$sheet->getColumnDimension('D')->setWidth(20);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Kejadian.xlsx"'); /*-- $filename is  xsl filename ---*/
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'name' => 'Laporan Kejadian',
			'op' => $_POST['frm'].' - '.$_POST['to'],
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($response);
	}
	
	// export kerusakan
	if($_POST["operation"] == "export" && $_POST["table"] == "kerusakan"){
		
		$event = new Event($db);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'SISTEM INFORMASI PENGADUAN');
		$sheet->mergeCells('A2:C2');
		$sheet->setCellValue('A4', 'Periode');
		$sheet->setCellValue('B4', 'Judul');
		$sheet->setCellValue('A5', $_POST['frm']." - ".$_POST['to']);
		$sheet->setCellValue('B5', 'Laporan Kejadian');
		$sheet->mergeCells('B5:C5');
		
		//header
		$sheet->setCellValue('A7', 'Judul');
		$sheet->setCellValue('B7', 'Lokasi');
		$sheet->setCellValue('C7', 'Kasus');
		$sheet->setCellValue('D7', 'Tanggal');
		
		$arr = array(
			'from' => $_POST['frm'],
			'to' => $_POST['to'],
			'kasus' => 2
		);
		
		$data = $event->exportKejadian($arr);
		
		$no = 1;
		$num_row = 8;
		foreach ($data as $row) {
		  $sheet->setCellValue('A'.$num_row, $row['judul']);
		  $sheet->setCellValue('B'.$num_row, $row['lokasi']);
		  $sheet->setCellValue('C'.$num_row, $row['kasus']);
		  $sheet->setCellValue('D'.$num_row, $row['tanggal']);
		  $no++;
		  $num_row++;
		}
		
		$sheet->getColumnDimension('A')->setWidth(60);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(10);
		$sheet->getColumnDimension('D')->setWidth(20);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Kejadian.xlsx"'); /*-- $filename is  xsl filename ---*/
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'name' => 'Laporan Kerusakan',
			'op' => $_POST['frm'].' - '.$_POST['to'],
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($response);
	}

	// export kecelakaan
	if($_POST["operation"] == "export" && $_POST["table"] == "kecelakaan"){
		
		$event = new Event($db);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'SISTEM INFORMASI PENGADUAN');
		$sheet->mergeCells('A2:C2');
		$sheet->setCellValue('A4', 'Periode');
		$sheet->setCellValue('B4', 'Judul');
		$sheet->setCellValue('A5', $_POST['frm']." - ".$_POST['to']);
		$sheet->setCellValue('B5', 'Laporan Kecelakaan');
		$sheet->mergeCells('B5:C5');
		
		//header
		$sheet->setCellValue('A7', 'Kode');
		$sheet->setCellValue('B7', 'Tanggal');
		$sheet->setCellValue('C7', 'Penumpang');
		$sheet->setCellValue('D7', 'Saksi');
		$sheet->setCellValue('E7', 'Tersangka');
		$sheet->setCellValue('F7', 'Korban');
		$sheet->setCellValue('G7', 'Keterangan');
		
		$arr = array(
			'from' => $_POST['frm'],
			'to' => $_POST['to']
		);
		
		$data = $event->exportKecelakaan($arr);
		
		$no = 1;
		$num_row = 8;
		foreach ($data as $row) {
		  $sheet->setCellValue('A'.$num_row, $row['kode']);
		  $sheet->setCellValue('B'.$num_row, $row['tanggal']);
		  $sheet->setCellValue('C'.$num_row, $event->totalRow($row['id'], 'penumpang'));
		  $sheet->setCellValue('D'.$num_row, $event->totalRow($row['id'], 'saksi'));
		  $sheet->setCellValue('E'.$num_row, $event->totalRow($row['id'], 'tersangka'));
		  $sheet->setCellValue('F'.$num_row, $event->totalRow($row['id'], 'korban'));
		  $sheet->setCellValue('G'.$num_row, $row['keterangan']);
		  $no++;
		  $num_row++;
		}
		
		$sheet->getColumnDimension('A')->setWidth(30);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(12);
		$sheet->getColumnDimension('D')->setWidth(10);
		$sheet->getColumnDimension('E')->setWidth(10);
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(40);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Kecelakaan.xlsx"'); /*-- $filename is  xsl filename ---*/
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'name' => 'Laporan Kecelakaan',
			'op' => $_POST['frm'].' - '.$_POST['to'],
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($response);
	}
	
	if($_POST["operation"] == "export" && $_POST["table"] == "lapKerusakan"){
		
		$event = new Event($db);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'SISTEM INFORMASI PENGADUAN');
		$sheet->mergeCells('A2:C2');
		$sheet->setCellValue('A4', 'Periode');
		$sheet->setCellValue('B4', 'Judul');
		$sheet->setCellValue('A5', $_POST['frm']." - ".$_POST['to']);
		$sheet->setCellValue('B5', 'Laporan Keluhan Kerusakan');
		$sheet->mergeCells('B5:C5');
		
		//header
		$sheet->setCellValue('A7', 'Judul');
		$sheet->setCellValue('B7', 'Lokasi');
		$sheet->setCellValue('C7', 'Pelapor');
		$sheet->setCellValue('D7', 'Tanggal');
		
		$arr = array(
			'from' => $_POST['frm'],
			'to' => $_POST['to'],
			'kasus' => 'kerusakan'
		);
		
		$data = $event->exportKeluhan($arr);
		
		$no = 1;
		$num_row = 8;
		foreach ($data as $row) {
		  $sheet->setCellValue('A'.$num_row, $row['judul']);
		  $sheet->setCellValue('B'.$num_row, $row['lokasi']);
		  $sheet->setCellValue('C'.$num_row, $row['pelapor']);
		  $sheet->setCellValue('D'.$num_row, $row['tanggal']);
		  $no++;
		  $num_row++;
		}
		
		$sheet->getColumnDimension('A')->setWidth(60);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Keluhan Kerusakan.xlsx"'); /*-- $filename is  xsl filename ---*/
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'name' => 'Laporan Keluhan Kerusakan',
			'op' => $_POST['frm'].' - '.$_POST['to'],
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($response);
	}
	
	if($_POST["operation"] == "export" && $_POST["table"] == "lapKejadian"){
		
		$event = new Event($db);
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'SISTEM INFORMASI PENGADUAN');
		$sheet->mergeCells('A2:C2');
		$sheet->setCellValue('A4', 'Periode');
		$sheet->setCellValue('B4', 'Judul');
		$sheet->setCellValue('A5', $_POST['frm']." - ".$_POST['to']);
		$sheet->setCellValue('B5', 'Laporan Keluhan Kejadian');
		$sheet->mergeCells('B5:C5');
		
		//header
		$sheet->setCellValue('A7', 'Judul');
		$sheet->setCellValue('B7', 'Lokasi');
		$sheet->setCellValue('C7', 'Pelapor');
		$sheet->setCellValue('D7', 'Tanggal');
		
		$arr = array(
			'from' => $_POST['frm'],
			'to' => $_POST['to'],
			'kasus' => 'kejadian'
		);
		
		$data = $event->exportKeluhan($arr);
		
		$no = 1;
		$num_row = 8;
		foreach ($data as $row) {
		  $sheet->setCellValue('A'.$num_row, $row['judul']);
		  $sheet->setCellValue('B'.$num_row, $row['lokasi']);
		  $sheet->setCellValue('C'.$num_row, $row['pelapor']);
		  $sheet->setCellValue('D'.$num_row, $row['tanggal']);
		  $no++;
		  $num_row++;
		}
		
		$sheet->getColumnDimension('A')->setWidth(60);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Keluhan Kejadian.xlsx"'); /*-- $filename is  xsl filename ---*/
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
			'name' => 'Laporan Keluhan Kejadian',
			'op' => $_POST['frm'].' - '.$_POST['to'],
			'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		);
		echo json_encode($response);
	}

	// data kecelakaan
	if($_POST["operation"] == "read" && $_POST["table"] == "kecelakaan"){
		$event = new Event($db);
		$query = '';
		$output = array();
		$query .= "SELECT a.id as id_k,a.kode, DATE(a.tanggal) as tgl, a.lokasi, b.nama 
					FROM kecelakaan a INNER JOIN admin b ON (b.id = a.admin_id) ";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'WHERE a.kode LIKE "%'.$_POST["search"]["value"].'%" ';
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
			$sub_array[] = $row['kode'];
			$sub_array[] = $row['tgl'];
			$sub_array[] = $row['lokasi'];
			$sub_array[] = $row['nama'];
			$sub_array[] = '
				<button type="button" name="edit" id="'.$row["id_k"].'" class="btn btn-primary btn-sm edit">View</button>
				';
			$data[] = $sub_array;
			$num++;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	$event->total_records('kecelakaan'),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	//show carousel kejadian
	if($_POST["operation"] == "show" && $_POST["table"] == "kejadian"){
		$event = new Event($db);
		$event->showKejadian(1);
	}

	//show news kejadian
	if($_POST["operation"] == "show" && $_POST["table"] == "kerusakan"){
		$event = new Event($db);
		$event->showKejadian(2);
	}

	//show news kejadian
	if($_POST["operation"] == "show" && $_POST["table"] == "berita"){
		$event = new Event($db);
		$event->showBerita();
	}

	if($_POST["operation"] == "graph" && $_POST["table"] == "laporan"){
		$lap = new Laporan($db);
		$lap->getDataLaporan();
	}

	if($_POST["operation"] == "graph" && $_POST["table"] == "kejadian"){
		$lap = new Laporan($db);
		$lap->getDataKejadian();
	}

	if($_POST["operation"] == "graph" && $_POST["table"] == "kerusakan"){
		$lap = new Laporan($db);
		$lap->getDataKerusakan();
	}

	if($_POST["operation"] == "graph" && $_POST["table"] == "kecelakaan"){
		$lap = new Laporan($db);
		$lap->getDataKecelakaan();
	}
  }
?>
