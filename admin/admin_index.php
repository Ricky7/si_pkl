<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";
	require_once "../helper/url.php";
	
	$admin = new Admin($db);
?>

<?php include "admin_header.php"; ?>
<?php include "admin_menu.php"; ?>
	<div class="container" id="contains">
		<div class="card">
			<div class="card-header">
				<strong>Dashboard</strong>
			</div>
			<div class="card-body">
				<?php
					$arr = array(
						'isLog' => $_SESSION['isAdminLog'],
						'admin_id' => $_SESSION['admin_session'],
						'admin_name' => $_SESSION['admin_nama']
					);
					
					echo '<pre>';
					echo print_r($arr);
					echo '</pre>';
				?>
			</div>
		</div>
	</div>
<?php include "admin_footer.php"; ?>