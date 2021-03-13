<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header

$jam = date("H.i.s");
$tgl = date("Y-m-d");

$id = $_GET['id'];
$action = $_POST['action'];

$nama_gambar = $_FILES['bukti']['name'];
$ukuran_gambar = $_FILES['bukti']['size'];
$tipe_gambar = $_FILES['bukti']['type'];
$tmp_gambar = $_FILES['bukti']['tmp_name'];
$path_gambar = "bukti-iuran/".$tgl."_".$jam."_".$nama_gambar;
$nama_simpan = $tgl."_".$jam."_".$nama_gambar;

$query_data_iuran = mysqli_query($conn, "select * from iuran, iuran_bukti_tf where iuran.id_iuran = iuran_bukti_tf.id_iuran and iuran_bukti_tf.id_bukti_iuran = '$id'");
$data_iuran = mysqli_fetch_assoc($query_data_iuran);

$query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
$data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);

if ($action == 'simpan data') {
    if ($_FILES['bukti']['name'] != null) {
        move_uploaded_file($tmp_gambar, $path_gambar) ;
        $simpan_gambar = "update iuran_bukti_tf set nama_foto_bukti_iuran = '$nama_simpan', ukuran_foto = '$ukuran_gambar', tgl_bayar = '$tgl', tipe = '$tipe_gambar', status = 'Menunggu' where id_bukti_iuran = '$id'";
        querydb($simpan_gambar);
        echo "<script type ='text/javascript'>alert('Bukti transfer berhasil diperbarui');</script>";
        echo "<meta http-equiv='refresh' content='0;url=anggota-home.php'>";   
    } else {
        echo "<script type ='text/javascript'>alert('Bukti transfer gagal diperbarui');</script>";
    }
        
}
?>


  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Bukti Pembayaran Iuran</h2>
          <ol>
            <li><a href="anggota-home.php">Iuran</a></li>
            <li>Bukti Pembayaran Iuran</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Iuran yang belum dibayarkan ======= -->
    <section >
      <div class="container">
          <div class="row">
              <div class="col-lg-6">
                  <table>
                    <tbody>
                        <tr>
                            <td><strong>Nominal Iuran</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;Rp <?php echo number_format($data_iuran['nominal_iuran'],0,',','.') ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Keterangan Iuran</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_iuran['keterangan_iuran'] ?> </td> 
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                            <td><strong>Tanggal Unggah</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_iuran['tgl_bayar'] ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_iuran['status'] ?> </td> 
                        </tr>
                        <tr style="<?php if ($data_iuran['status'] != 'Ditolak') { echo "display:none"; } ?>">
                            <td><strong>Alasan Penolakan</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_iuran['alasan_penolakan'] ?> </td> 
                        </tr>
                    </tbody>
                  </table>
              </div>
              <div class="col-lg-6">
                <h4><?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "Bukti Transfer"; } else { echo "Unggah Bukti transfer"; } ?></h4>
                    <div style=" overflow:hidden;">
                        <img class="card-img-top" id="output" style="min-height:300px; min-width:100px; " src="bukti-iuran/<?php echo $data_iuran['nama_foto_bukti_iuran']; ?>">
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