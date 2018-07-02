<?php 
	if(!$_SESSION['isAdminLog']){
		header('location: admin_login.php');
	}
?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Administrator</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="admin_index.php">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
		<li class="nav-item">
			<a class="nav-link" href="admin_laporan_page.php">Laporan warga</a>
		</li>
		<?php if($admin->isLog()){ ?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Kasus
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="admin_kejadian_page.php">Kejadian</a>
			  <div class="dropdown-divider"></div>
			  <a class="dropdown-item" href="admin_kerusakan_page.php">Kerusakan</a>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="admin_berita_page.php">Berita</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="admin_report_page.php">Report</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="admin_logout.php">Logout</a>
		</li>
        <?php } else { ?>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
