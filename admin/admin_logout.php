<?php 
	require_once "../db_connect.php";
	require_once "../class/Admin.php";

	$admin = new Admin($db);

    $admin->logout();

    // Redirect ke login
    header('location: admin_login.php');
?>