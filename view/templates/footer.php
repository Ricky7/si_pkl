<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; Sistem Informasi Pengaduan 2018</p>
  </div>
  <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="././js/jquery-confirm.min.js" charset="utf-8"></script>

</body>
</html>
<script>
var uri = "<?php echo $_SERVER['REQUEST_URI'] ?>";
if(uri != '/index.php'){
  $('.regNav').hide();
  $('.logNav').hide();
}
</script>
