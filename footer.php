<!-- ======= Footer ======= -->
  <footer id="footer" class="section-bg">

    

    <div class="footer-top ">
      <div class="container ">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><a href="index.html"><img style="max-height: 40px;" src="logo/<?php echo $data_logo['nama_logo']; ?>"></a></h3>
            <p>
              <?php echo $data_komunitas['alamat']; ?><br>
              <strong>Phone:</strong> <?php echo $data_komunitas['tlp']; ?><br>
              <strong>Email:</strong> <?php echo $data_komunitas['email']; ?><br>
            </p>
          </div>

          <div class="col-lg-6 col-md-6 footer-links">
            <h4>Menu</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="berita.php">Berita</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="merchandise.php">Merchandise</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="login-anggota.php">Log In</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <div class="social-links mt-3">
              <a <?php if ($data_komunitas['link_twitter'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_twitter']; ?>" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a <?php if ($data_komunitas['link_facebook'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_facebook']; ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a <?php if ($data_komunitas['link_instagram'] == '') {echo "style='display:none'";} ?> href="<?php echo $data_komunitas['link_instagram']; ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span><?php echo $data_komunitas['nama_komunitas']; ?></span></strong>. 
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

<!-- Page level plugins -->
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
    <script src="admin/js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        (function ($) {
            //    "use strict";


            /*  Data Table
            -------------*/

            $('#bootstrap-data-table').DataTable({
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
            });

            $('#bootstrap-data-table-export').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });

            $('#table').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            });

            $('#row-select').DataTable( {
                initComplete: function () {
                        this.api().columns().every( function () {
                            var column = this;
                            var select = $('<select class="form-control"><option value=""></option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    }
                } );

        })(jQuery);

    </script>

    <!-- upload gambar -->
    <script type="text/javascript">
	  var loadFile = function(event) {
	    var output = document.getElementById('output');
	    output.src = URL.createObjectURL(event.target.files[0]);
	  };
	</script>

</body>

</html>