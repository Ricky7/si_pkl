<?php
	require_once "../db_connect.php";
	require_once "../class/User.php";
	require_once "../class/Admin.php";
	require_once "../class/Event.php";
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
  }
?>
