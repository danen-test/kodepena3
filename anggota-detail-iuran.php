<?php
// Memanggil header 
include "header-anggota.php";
// End Memanggil header

error_reporting(0);

$jam = date("H.i.s");
$tgl = date("Y-m-d");
$bln_thn = date("my");
$bln = date("m");
$thn = date("Y");

$id = $_GET['id'];
$action = $_POST['action'];

$nama_gambar = $_FILES['bukti']['name'];
$ukuran_gambar = $_FILES['bukti']['size'];
$tipe_gambar = $_FILES['bukti']['type'];
$tmp_gambar = $_FILES['bukti']['tmp_name'];
$path_gambar = "bukti-iuran/".$tgl."_".$jam."_".$nama_gambar;
$nama_simpan = $tgl."_".$jam."_".$nama_gambar;

$query_data_iuran = mysqli_query($conn, "select * from iuran where id_iuran = '$id'");
$data_iuran = mysqli_fetch_assoc($query_data_iuran);

$query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
$data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);

if ($action == 'simpan data') {
    if ($_FILES['bukti']['name'] != null) {
        $query_gambar = mysqli_query($conn, "select * from iuran_bukti_tf where month (tgl_bayar) = '$bln' and year (tgl_bayar) = '$thn'");
        $jumlah_gambar = mysqli_num_rows($query_gambar);
        $id_gambar = "BI".$bln_thn.($jumlah_gambar+10001); // BI = GBukti Iuran
        move_uploaded_file($tmp_gambar, $path_gambar) ;
        mysqli_query($conn, "insert into iuran_bukti_tf (id_bukti_iuran, nama_foto_bukti_iuran, ukuran_foto, tgl_bayar, tipe, status, id_iuran, id_anggota) values ('$id_gambar', '$nama_simpan', '$ukuran_gambar', '$tgl', '$tipe_gambar', 'Menunggu', '$id', '$data_user[id_anggota]')");
        
        echo "<script type ='text/javascript'>alert('Bukti transfer berhasil tersimpan');</script>";
        echo "<meta http-equiv='refresh' content='0;url=anggota-home.php'>";   
    } else {
        echo "<script type ='text/javascript'>alert('Bukti transfer gagal tersimpan');</script>";
    }
        
}
?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Detail Iuran</h2>
          <ol>
            <li><a href="anggota-home.php">Iuran</a></li>
            <li>Detail Iuran</li>
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
                    </tbody>
                  </table>
                  <div class="mt-4" style="<?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "display:none"; } ?>">
                      <h4>Tata cara pembayaran iuran</h4>
                      <?php echo $data_pembayaran['tata_cara'] ?>
                  </div>
              </div>
              <div class="col-lg-6">
                <h4><?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "Bukti Transfer"; } else { echo "Unggah Bukti transfer"; } ?></h4>

                  <form action="" method="post" enctype="multipart/form-data">
                    <div style=" overflow:hidden;">
                        <img class="card-img-top" id="output" style="min-height:300px; min-width:100px; " src="assets/img/default.jpg">
                    </div>
                    <input class="custom-file" type="file"  onchange="loadFile(event)" name="bukti" required="required">
                    <div class="text-center ">
                      <button type="submit" name="action" value="simpan data" class="btn btn-primary btn-block btn-icon-split">
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