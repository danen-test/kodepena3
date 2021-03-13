<?php
//Memanggil header
include "header.php";
//End Memanggil header

$id = $_GET['id'];

$query_data_berita = mysqli_query($conn, "select * from berita where id_berita = '$id'");
$data_berita = mysqli_fetch_assoc($query_data_berita);

$query_gambar_berita = mysqli_query($conn, "select * from berita_gambar where id_berita = '$id'");
$gambar_berita = mysqli_fetch_assoc($query_gambar_berita);
?>


      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="berita.php">Berita</a></li>
          <li><a href="merchandise.php">Merchandise</a></li>
          <li><a href="login-anggota.php">Log In</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Berita</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="berita.php">Berita</a></li>
            <li>Detail Berita</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Portfolio Details Section ======= -->
    <section class="portfolio-details">
      <div class="container">

        <div class="portfolio-details-container">

          <div class="owl-carousel portfolio-details-carousel" style="max-height:600px;  overflow:hidden;  ">
            <img src="berita/<?php echo $gambar_berita['nama_gambar_berita']; ?>" >
            
          </div>

          <div class="portfolio-info">
            <ul>
              <li><strong>Penulis</strong>: <?php echo $data_berita['penulis']; ?></li>
              <li><strong>Tanggal</strong>: <?php echo $data_berita['tgl_berita']; ?></li>
            </ul>
          </div>

        </div>

        <div class="portfolio-description">
          <h2><?php echo $data_berita['judul_berita']; ?></h2>
          <p>
            <?php echo $data_berita['isi_berita']; ?>
          </p>
        </div>
      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

<!-- Memanggil footer -->
<?php
include "footer.php";
?>
<!-- End Memanggil footer -->