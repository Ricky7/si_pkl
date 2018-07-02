<div id="fadeLoader"></div>
<div id="modalLoader">
    <img id="loader" src="<?php echo getBaseUrl().'images/loader.gif' ?>" width="64%" height="64%" />
</div>
<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; Administrator Sistem Informasi Pengaduan 2018</p>
  </div>
  <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/jquery-confirm.min.js" charset="utf-8"></script>
<script src="<?php echo getBaseUrl().'js/tinymce/tinymce.min.js' ?>"></script>
<script>var base_url = '<?php echo getBaseUrl() ?>';</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7zVeusOAU0YBF9JtwV97OXVM9dowacso&sensor=false&language=en"></script>
<script src="<?php echo getBaseUrl().'dist/jquery.addressPickerByGiro.js' ?>"></script>

<script src="<?php echo getBaseUrl().'DataTables-1.10.18/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?php echo getBaseUrl().'DataTables-1.10.18/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?php echo getBaseUrl().'js/flatpickr.js' ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->
<script>

function openModalLoader() {
    document.getElementById('modalLoader').style.display = 'block';
    document.getElementById('fadeLoader').style.display = 'block';
}

function closeModalLoader() {
    document.getElementById('modalLoader').style.display = 'none';
    document.getElementById('fadeLoader').style.display = 'none';
}
</script>
</body>
</html>
