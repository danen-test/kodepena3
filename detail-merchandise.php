<?php
//Memanggil header
include "header.php";
//End Memanggil header

$id = $_GET['id'];

$tgl = date("Y-m-d");

$query_data_merch = mysqli_query($conn, "select * from merchandise where id_merchandise = '$id'");
$data_merch = mysqli_fetch_assoc($query_data_merch);

$query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
$data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);

$query_pembelian = mysqli_query($conn, "select sum(jumlah) as total from merchandise_pembelian where id_merchandise = '$id' and status != 'Terkonfirmasi' and status != 'Menunggu konfirmasi admin' and datediff('$tgl', tgl_update) <= '$data_pembayaran[tenggat_waktu]' ");
$pembelian = mysqli_fetch_assoc($query_pembelian);

$stok = $data_merch['stok'] - $pembelian['total'];
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

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Merchandise</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="merchandise.php">Merchandise</a></li>
            <li>Merchandise Detail</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Portfolio Details Section ======= -->
    <section class="portfolio-details">
      <div class="container">

        <div class="portfolio-details-container">

          <div class="owl-carousel portfolio-details-carousel">
              <?php
              $query_gambar_merch = mysqli_query($conn, "select * from merchandise_gambar where id_merchandise = '$id'");
              while($gambar_merch = mysqli_fetch_assoc($query_gambar_merch)){
              ?>
              <div style="max-height:700px; min-height:400px; overflow:hidden; ">
                <center>
                    <img class="img-fluid" alt="" style="height:700px; width:auto;  " src="<?php if ($gambar_merch == 0) { echo 'assets/img/default.jpg'; } else { echo 'merchandise/'.$gambar_merch['nama_gambar_merchandise']; } ?>">
                </center>
            </div>
              <?php }; ?>
          </div>

          <div class="portfolio-info">
            <h3><?php echo $data_merch['nama_merchandise'] ?></h3>
            <ul>
              <li><strong>Harga</strong>: Rp <?php echo number_format($data_merch['harga'],0,',','.');?></li>
              <li><strong>Stok</strong>: <?php echo $stok ?></li>
              <li>
                  <div class="text-center ">
                      <a href="login-anggota.php" class="btn btn-primary btn-block btn-icon-split">
                          <span class="text">Beli</span>
                      </a>
                  </div>
              </li>
            </ul>
          </div>

        </div>

        <div class="portfolio-description">
            <h2></h2>
          <p>
            <?php echo $data_merch['deskripsi_merchandise'] ?>
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