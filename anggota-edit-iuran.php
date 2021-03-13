<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header

error_reporting(0);

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
        mysqli_query($conn, "update iuran_bukti_tf set nama_foto_bukti_iuran = '$nama_simpan', ukuran_foto = '$ukuran_gambar', tgl_bayar = '$tgl', tipe = '$tipe_gambar', status = 'Menunggu' where id_bukti_iuran = '$id'");
        
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
              <div class="col-md-6">
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
                            <td><strong>Nomor Rekening Tujuan Transfer</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembayaran['no_rekening'] ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Pemilik Rekening</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembayaran['pemilik'] ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Bank Tujuan</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembayaran['nama_bank'] ?> </td> 
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

                  <div  style="<?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "display:none"; } ?>">
                      <h4 class="mt-4" >Tata cara pembayaran iuran</h4>
                      <?php echo $data_pembayaran['tata_cara'] ?>
                  </div>
              </div>
              <div class="col-md-6">
                    <h4 ><?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "Bukti Transfer"; } else { echo "Unggah Bukti transfer"; } ?></h4>

                    <form action="" method="post" enctype="multipart/form-data">
                    <div style=" overflow:hidden;">
                        <img class="card-img-top" id="output" style="min-height:300px; min-width:100px; " src="bukti-iuran/<?php echo $data_iuran['nama_foto_bukti_iuran']; ?>">
                    </div>
                    <input style="<?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "display:none"; } ?>" class="custom-file" type="file"  onchange="loadFile(event)" name="bukti" required="required">
                    <div class="text-center ">
                      <button type="submit" name="action" value="simpan data" class="btn btn-primary btn-block btn-icon-split" style="<?php if ($data_iuran['status'] == 'terkonfirmasi') { echo "display:none"; } ?>">
                          <i class="fa fa-save"></i>
                          <span class="text">Simpan</span>
                      </button>
                    </div>
                  </form>
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