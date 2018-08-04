<?php
  require_once "db_connect.php";
  require_once "class/User.php";

  $user = new User($db);

  if($user->isLog()){
    $dataUser = $user->getUser();
  }

  $id = $_REQUEST['s'];
  $table = $_REQUEST['j'];

?>
<?php include "view/templates/header.php"; ?>
<?php include "view/templates/menu.php"; ?>

  <!-- Header - set the background image for the header in the line below -->
  <header class="py-5 bg-image-full" style="background-image: url('https://unsplash.it/1900/1080?image=1076');">
    <img class="img-fluid d-block mx-auto" src="images/logo_polantas.png" width="150px" height="150px" alt="">
  </header>
  <?php
        $query = "SELECT * FROM {$table} WHERE id={$id}";

        $stmt = $db->prepare($query);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        
  ?>
  <div class="row">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                <div id="judul">
                    <center><strong><?php echo $row['judul'] ?></strong></center>
                </div>
              </div>
              <div class="card-body">
                <div id="img">
                    <center>
                        <img src="gambar/<?php echo $row['gambar'] ?>" width="50%" height="50%">
                    </center>
                </div>
                <div id="vid" style="padding-top:30px">
                  <center>
                    <video id="myVideo" width="480" height="360" onclick="this.paused ? this.play() : this.pause();">
                      <source src="video/<?php echo $row['video'] ?>" type="video/mp4">
                      Your browser does not support HTML5 video.
                    </video>
                  </center>
                </div>
                <p id="isi"><?php echo $row['isi'] ?></p>
              </div>
              <div class="card-footer">

              </div>
          </div>
      </div>
  </div>

<?php include "view/templates/footer.php"; ?>

