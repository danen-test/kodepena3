<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header

$id = $_GET['id'];

$query_data_pembelian = mysqli_query($conn, "select * from merchandise_pembelian where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]'");
$data_pembelian = mysqli_fetch_assoc($query_data_pembelian);

$query_data_bukti = mysqli_query($conn, "select * from merchandise_bukti_tf where id_pembelian_merch = '$data_pembelian[id_pembelian_merch]'");
$data_bukti = mysqli_fetch_assoc($query_data_bukti);

?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Detail Riwayat Pembelian Merchandise</h2>
          <ol>
            <li><a href="anggota-home.php">Home</a></li>
            <li><a href="anggota-merchandise.php">Merchandise</a></li>
            <li>Detail Riwayat Pembelian Merchandise</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Iuran yang belum dibayarkan ======= -->
    <section >
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <table>
                    <tbody>
                        <tr>
                            <td><strong>Harga Per Merchandise</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;Rp <?php echo number_format($data_pembelian['harga_satuan'],0,',','.') ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Jumlah Yang Dibeli</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['jumlah'] ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Harga Total</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<strong><h5>Rp <?php echo number_format($data_pembelian['total_harga'],0,',','.') ?></h5></strong> </td> 
                        </tr>
                        
                        <tr><td><br></td></tr>
                        <tr>
                            <td><strong>Status</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['status'] ?> </td> 
                        </tr>
                        <tr <?php if ($data_pembelian['status'] != 'Ditolak') { echo "style='display:none;'"; } ?>>
                            <td><strong>Alasan Penolakan</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['alasan_penolakan'] ?> </td> 
                        </tr>
                    </tbody>
                  </table>
              </div>
          
          <div class="col-lg-6">
            <h4>Bukti Transfer</h4>
              <div style=" overflow:hidden;">
                    <img class="card-img-top" id="output" style="min-height:300px; min-width:100px; " src="<?php if ($data_bukti == '') { echo 'assets/img/default.jpg'; } else { echo 'bukti-merch/'.$data_bukti['nama_foto_bukti_merch']; } ?>">
                </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Iuran yang belum dibayarkan -->

  </main><!-- End #main -->
<!-- Memanggil footer -->
<?php
include "footer-anggota.php";
?>
<!-- End Memanggil footer -->