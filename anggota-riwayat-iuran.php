<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header
?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Riwayat Pembayaran Iuran</h2>
          <ol>
            <li><a href="home-anggota.php">Iuran</a></li>
            <li>Riwayat Pembayaran Iuran</li>
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
                            <th>Tanggal Ditambahkan</th>
                            <th>Nominal Iuran</th>
                            <th>Keterangan Iuran</th>
                            <th>Tanggal Bayar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_data_iuran = mysqli_query($conn, "select * from iuran, iuran_bukti_tf where iuran.id_iuran = iuran_bukti_tf.id_iuran and iuran_bukti_tf.status = 'terkonfirmasi' and iuran_bukti_tf.id_anggota = '$data_user[id_anggota]'");
                        while ($data_iuran = mysqli_fetch_assoc($query_data_iuran)) {
                            $nominal = number_format($data_iuran['nominal_iuran'],0,',','.');
                            
                        ?>
                        <tr>
                            <td><?php echo $data_iuran['tgl'] ?></td>
                            <td>Rp <?php echo $nominal ?></td>
                            <td><?php echo $data_iuran['keterangan_iuran'] ?></td>
                            <td><?php echo $data_iuran['tgl'] ?></td>
                            <td> 
                                <div class="text-center">
                                  <a href="anggota-pembayaran-iuran.php?id=<?php echo $data_iuran['id_bukti_iuran'] ?>" class="btn btn-primary btn-icon-split">
                                      <span class="text">Lihat</span>
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