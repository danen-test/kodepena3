<?php
//Memanggil header
include "header-anggota.php";
//End Memanggil header

$jam = date("H.i.s");
$tgl = date("Y-m-d");
$bln_thn = date("my");
$bln = date("m");
$thn = date("Y");

$id = $_GET['id'];
$jumlah = $_POST['jumlah'];
$action = $_POST['action'];

$query_data_merch = mysqli_query($conn, "select * from merchandise where id_merchandise = '$id'");
$data_merch = mysqli_fetch_assoc($query_data_merch);

$query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
$data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);

$query_pembelian = mysqli_query($conn, "select sum(jumlah) as total from merchandise_pembelian where id_merchandise = '$id' and status != 'Terkonfirmasi' and status != 'Menunggu konfirmasi admin' and datediff('$tgl', tgl_update) <= '$data_pembayaran[tenggat_waktu]' ");
$pembelian = mysqli_fetch_assoc($query_pembelian);

$stok = $data_merch['stok'] - $pembelian['total'];

$harga = $data_merch['harga'];
$total= $harga * $jumlah;

if ($action == 'simpan data') {
    $query_pembelian = mysqli_query($conn, "select * from merchandise_pembelian where month (tgl_beli) = '$bln' and year (tgl_beli) = '$thn'");
    $jumlah_pembelian = mysqli_num_rows($query_pembelian);
    $id_pembelian = "PN".$bln_thn.($jumlah_pembelian+10001); // PN = Pembelian
    
    mysqli_query($conn, "insert into merchandise_pembelian (id_pembelian_merch, tgl_beli, jumlah, harga_satuan, total_harga, status, tgl_update, id_anggota, id_merchandise) values ('$id_pembelian', '$tgl', '$jumlah', '$data_merch[harga]', '$total', 'Belum dibayar', '$tgl', '$data_user[id_anggota]', '$data_merch[id_merchandise]')");
    
    echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id_pembelian."'>";
}
?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Merchandise</h2>
          <ol>
            <li><a href="anggota-home.php">Home</a></li>
            <li><a href="anggota-merchandise.php">Merchandise</a></li>
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
                <center>
                    <a href="<?php if ($gambar_merch == 0) { echo 'assets/img/default.jpg'; } else { echo 'merchandise/'.$gambar_merch['nama_gambar_merchandise']; } ?>" data-gall="portfolioGallery" class="venobox preview-link" title="App 1">
                        <img class="img-fluid" alt="" style="max-height:700px; width:auto;  " src="<?php if ($gambar_merch == 0) { echo 'assets/img/default.jpg'; } else { echo 'merchandise/'.$gambar_merch['nama_gambar_merchandise']; } ?>">
                    </a>
                </center>
              <?php }; ?>
          </div>

          <div class="portfolio-info">
            <h3><?php echo $data_merch['nama_merchandise'] ?></h3>
            <ul>
              <li><strong>Harga</strong>: Rp <?php echo number_format($data_merch['harga'],0,',','.');?></li>
              <li><strong>Stok</strong>: <?php echo $stok ?></li>
              <li>
                  <div class="text-center ">
                      <a  class="btn btn-primary btn-block btn-icon-split" data-toggle="modal" data-target="#pembelian">
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
<form action="" method="post">
    <div class="modal fade" id="pembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masukkan Jumlah Pembelian</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 ">
                        <center>
                    <table>
                        <tr>
                            <td><strong>Harga per merchandise</strong></td> 
                            <td>&nbsp;:&nbsp;</td> 
                            <td>Rp <?php echo number_format($data_merch['harga'],0,',','.');?></td> 
                        </tr>
                        <tr>
                            <td><strong>Stok</strong></td> 
                            <td>&nbsp;:&nbsp;</td> 
                            <td><?php echo $stok ?></td> 
                        </tr>
                        <tr>
                            <td><strong>Jumlah yang dibeli</strong></td> 
                            <td>&nbsp;:&nbsp;</td> 
                            <td><input type="number" name="jumlah" class="form-control col-md-12" min="1" max="<?php echo $stok ?>" required></td> 
                        </tr>
                    </table>
                            </center>
                    </div>
                    <input type="text" class="form-control" name="id" value="<?php echo $data_merch['id_merchandise']; ?>" style="display:none">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" name="action" value="simpan data" type="submit">Check Out</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Memanggil footer -->
<?php
include "footer-anggota.php";
?>
<!-- End Memanggil footer -->