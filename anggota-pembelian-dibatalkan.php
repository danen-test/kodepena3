<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header

$tgl = date("Y-m-d");
?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Pembelian Dibatalakan</h2>
          <ol>
            <li><a href="home-anggota.php">Home</a></li>
            <li>Dibatalkan</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Iuran yang belum dibayarkan ======= -->
    <section >
      <div class="container">
        <div class="table-responsive mt-2">
                <table class="table table-bordered" id="bootstrap-data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none">Nomor</th>
                            <th>Tanggal Pembelian</th>
                            <th>Nama Merchandise</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        
                        $query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
                        $data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);
                        
                        $query_data_pembelian = mysqli_query($conn, "select * from merchandise_pembelian, merchandise where merchandise_pembelian.id_merchandise = merchandise.id_merchandise and merchandise_pembelian.id_anggota = '$data_user[id_anggota]'  and datediff('$tgl', tgl_update) > '$data_pembayaran[tenggat_waktu]'  order by merchandise_pembelian.tgl_beli");
                        while ($data_pembelian = mysqli_fetch_assoc($query_data_pembelian)) {
                            $no++;
                        ?>
                        <tr>
                            <td style="display:none"><?php echo $no ?></td>
                            <td><?php echo $data_pembelian['tgl_beli'] ?></td>
                            <td><?php echo $data_pembelian['nama_merchandise'] ?></td>
                            <td>Rp <?php echo number_format($data_pembelian['harga'],0,',','.'); ?></td>
                            <td>Rp <?php echo number_format($data_pembelian['total_harga'],0,',','.'); ?></td>
                            <td><?php echo $data_pembelian['status'] ?></td>
                            <td>
                                <div class="text-center">
                                    <a href="anggota-detail-pembelian.php?id=<?php echo $data_pembelian['id_pembelian_merch'] ?>" class="btn btn-primary btn-icon-split">
                                      <span class="text">Detail Pembelian</span>
                                    </a>
                                </div> 
                            </td>
                        </tr>
                        <?php }; ?>
                        
                        
                    </tbody>
                </table>
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