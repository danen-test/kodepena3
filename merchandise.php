<?php
//Memanggil header
include "header.php";
//End Memanggil header

?>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li class="active"><a href="merchandise.php">Merchandise</a></li>
          <li><a href="login-anggota.php">Log In</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Merchandise</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Merchandise</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Merchandise Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Merchandise</h2>
          <h3>Merchandise <span>Kodepena</span></h3>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <?php
              $query_data_kategori = mysqli_query($conn, "select * from merchandise_kategori");
              while($data_kategori = mysqli_fetch_assoc($query_data_kategori)){
              ?>
              <li data-filter=".filter-<?php echo $data_kategori['id_kategori']; ?>"><?php echo $data_kategori['nama_kategori']; ?></li>
              <?php }; ?>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <?php
        $query_data_merchandise = mysqli_query($conn, "select * from merchandise");
        while($data_merchandise = mysqli_fetch_assoc($query_data_merchandise)){
            $query_gambar_merch = mysqli_query($conn, "select * from merchandise_gambar where id_merchandise = '$data_merchandise[id_merchandise]'");
            $gambar_merch = mysqli_fetch_assoc($query_gambar_merch);
            
            $query_kategori = mysqli_query($conn, "select * from merchandise_kategori where id_kategori = '$data_merchandise[id_kategori]'");
            $kategori = mysqli_fetch_assoc($query_kategori);
        ?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-<?php echo $kategori['id_kategori']; ?>">
            <a href="detail-merchandise.php?id=<?php echo $data_merchandise['id_merchandise']; ?>" class="details-link" title="More Details">
                <img src="<?php if ($gambar_merch == 0) { echo 'assets/img/default.jpg'; } else { echo 'merchandise/'.$gambar_merch['nama_gambar_merchandise']; } ?>" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4><?php echo $data_merchandise['nama_merchandise'] ?></h4>
                  <p>Rp <?php echo number_format($data_merchandise['harga'],0,',','.');?></p>
                </div>
            </a>
          </div>
        <?php }; ?>
          

        </div>

      </div>
    </section><!-- End Merchandise Section -->

  </main><!-- End #main -->

<!-- Memanggil footer -->
<?php
include "footer.php";
?>
<!-- End Memanggil footer -->