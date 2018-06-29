<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Pengaduan Kecelakaan</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <?php if($user->isLog()){ ?>
		<<li class="nav-item">
			<a class="nav-link" href="kejadian.php">Lapor</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="logout.php">Logout</a>
		</li>
        <?php } else { ?>
        <li class="nav-item">
			<a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Register</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
