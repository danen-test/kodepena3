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
$jumlah = $_POST['jumlah'];
$action = $_POST['action'];

$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$penerima = $_POST['penerima'];
$tlp = $_POST['tlp'];
$catatan = $_POST['catatan'];

$query_data_pembelian = mysqli_query($conn, "select * from merchandise_pembelian where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]'");
$data_pembelian = mysqli_fetch_assoc($query_data_pembelian);

$query_data_merch = mysqli_query($conn, "select * from merchandise where id_merchandise = '$data_pembelian[id_merchandise]'");
$data_merch = mysqli_fetch_assoc($query_data_merch);

$query_data_tujuan = mysqli_query($conn, "select * from tujuan_pengiriman where id_anggota = '$data_user[id_anggota]'");
$data_tujuan = mysqli_fetch_assoc($query_data_tujuan);

$query_data_bukti = mysqli_query($conn, "select * from merchandise_bukti_tf where id_pembelian_merch = '$data_pembelian[id_pembelian_merch]'");
$data_bukti = mysqli_fetch_assoc($query_data_bukti);

$query_data_pembayaran = mysqli_query($conn, "select * from pembayaran");
$data_pembayaran = mysqli_fetch_assoc($query_data_pembayaran);

$query_pembelian = mysqli_query($conn, "select sum(jumlah) as total from merchandise_pembelian where id_merchandise = '$data_pembelian[id_merchandise]' and status = 'Belum dibayar' or status = 'Menunggu konfirmasi admin' or status = 'Ditolak' and datediff('$tgl', tgl_beli) <= '$data_pembayaran[tenggat_waktu]' ");
$pembelian = mysqli_fetch_assoc($query_pembelian);

$stok = $data_merch['stok'] - $pembelian['total'] + $data_pembelian['jumlah'];

$tenggat = $data_pembayaran['tenggat_waktu'] + 1;
$kadaluarsa = date('Y-m-d', strtotime('+ '.$tenggat.' days', strtotime($data_pembelian['tgl_update'])));

$nama_gambar = $_FILES['bukti']['name'];
$ukuran_gambar = $_FILES['bukti']['size'];
$tipe_gambar = $_FILES['bukti']['type'];
$tmp_gambar = $_FILES['bukti']['tmp_name'];
$path_gambar = "bukti-merch/".$tgl."_".$jam."_".$data_user['id_anggota']."_".$nama_gambar;
$nama_simpan = $tgl."_".$jam."_".$data_user['id_anggota']."_".$nama_gambar;

if ($action == 'simpan data') {
    $harga = $data_merch['harga'];
    $total= $harga * $jumlah;
    
    $simpan_pembelian = mysqli_query($conn,"update merchandise_pembelian set jumlah = '$jumlah', total_harga = '$total' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]' ");
    
    if ($simpan_pembelian) {
        echo "<script type ='text/javascript'>alert('Jumlah pembelian berhasil diubah');</script>"; 
        echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";
    } else {
        echo "<script type ='text/javascript'>alert('Jumlah pembelian gagal diubah, silahkan coba beberapa saat lagi');</script>";
    }
    
}



if ($action == 'simpan bukti') {
    $query_cek_bukti = mysqli_query($conn, "select * from merchandise_bukti_tf where id_pembelian_merch = '$id'");
    $cek_bukti = mysqli_num_rows($query_cek_bukti);
    if ($cek_bukti < 1) {
         if ($_FILES['bukti']['name'] != null) {
            $query_gambar = mysqli_query($conn, "select * from merchandise_bukti_tf where month (tgl_upload) = '$bln' and year (tgl_upload) = '$thn'");
            $jumlah_gambar = mysqli_num_rows($query_gambar);
            $id_gambar = "BM".$bln_thn.($jumlah_gambar+10001); // BM = Bukti Merchandise

            move_uploaded_file($tmp_gambar, $path_gambar) ;
            mysqli_query($conn, "insert into merchandise_bukti_tf (id_bukti_merch, tgl_upload, nama_foto_bukti_merch, id_anggota, id_pembelian_merch) values ('$id_gambar', '$tgl', '$nama_simpan', '$data_user[id_anggota]', '$data_pembelian[id_pembelian_merch]')");
             
            $stok_akhir = $data_merch[stok] - $data_pembelian['jumlah'];
            $terjual = $data_merch[terjual] + $data_pembelian['jumlah'];
            mysqli_query($conn, "update merchandise set stok = '$stok_akhir', terjual = '$terjual' where id_merchandise = '$data_merch[id_merchandise]'");
             
            mysqli_query($conn, "update merchandise_pembelian set catatan = '$catatan', status = 'Menunggu konfirmasi admin', tgl_update = '$tgl' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]' ");
            
            $query_tujuan = mysqli_query($conn, "select * from tujuan_pengiriman where month (tgl_ditambahkan) = '$bln' and year (tgl_ditambahkan) = '$thn'");
            $jumlah_tujuan = mysqli_num_rows($query_tujuan);
            $id_tujuan = "TN".$bln_thn.($jumlah_tujuan+10001); // TN = Tujuan
            mysqli_query($conn, "insert into tujuan_pengiriman (id_pengiriman, nama_penerima, tlp, alamat, kota, tgl_ditambahkan, id_anggota) values ('$id_tujuan', '$penerima', '$tlp', '$alamat', '$kota', '$tgl', '$data_user[id_anggota]')");
             
            echo "<script type ='text/javascript'>alert('Bukti transfer berhasil tersimpan');</script>";
            echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";

        } else {
            echo "<script type ='text/javascript'>alert('Bukti transfer gagal tersimpan');</script>";
        }   
    } else if ($cek_bukti >= 1) {
        if ($_FILES['bukti']['name'] != null) {
            if ($data_pembelian['status'] == 'Ditolak') {
                //update bukti setelah ditolak admin
                
                move_uploaded_file($tmp_gambar, $path_gambar) ;
                mysqli_query($conn, "update merchandise_bukti_tf set tgl_upload = '$tgl', nama_foto_bukti_merch = '$nama_simpan' where id_bukti_merch = '$data_bukti[id_bukti_merch]'");

                $stok_akhir = $data_merch['stok'] - $data_pembelian['jumlah'];
                $terjual = $data_merch['terjual'] + $data_pembelian['jumlah'];
                mysqli_query($conn, "update merchandise set stok = '$stok_akhir', terjual = '$terjual' where id_merchandise = '$data_merch[id_merchandise]'");
                
                mysqli_query($conn, "update merchandise_pembelian set catatan = '$catatan', status = 'Menunggu konfirmasi admin' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]' ");

                mysqli_query($conn, "update tujuan_pengiriman set nama_penerima = '$penerima', tlp = '$tlp', alamat = '$alamat', kota = '$kota' where id_anggota = '$data_user[id_anggota]'");
                
                echo "<script type ='text/javascript'>alert('Bukti transfer berhasil diubah');</script>";
                echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";
            } else if ($data_pembelian['status'] != 'Ditolak') {
                //update bukti sebelum dikonfirmasi admin
                
                move_uploaded_file($tmp_gambar, $path_gambar) ;
                mysqli_query($conn, "update merchandise_bukti_tf set tgl_upload = '$tgl', nama_foto_bukti_merch = '$nama_simpan' where id_bukti_merch = '$data_bukti[id_bukti_merch]'");

                mysqli_query($conn, "update merchandise_pembelian set catatan = '$catatan', status = 'Menunggu konfirmasi admin' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]'");
                
                mysqli_query($conn, "update tujuan_pengiriman set nama_penerima = '$penerima', tlp = '$tlp', alamat = '$alamat', kota = '$kota' where id_anggota = '$data_user[id_anggota]' ");

                echo "<script type ='text/javascript'>alert('Bukti transfer berhasil diubah');</script>";
                echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";
            }
        
          
        } else if ($_FILES['bukti']['name'] == null && $data_pembelian['status'] != 'Belum dibayar') {
            if ($data_pembelian['status'] == 'Ditolak') {
                //update bukti setelah ditolak admin
                

                $stok_akhir = $data_merch['stok'] - $data_pembelian['jumlah'];
                $terjual = $data_merch['terjual'] + $data_pembelian['jumlah'];
                mysqli_query($conn, "update merchandise set stok = '$stok_akhir', terjual = '$terjual' where id_merchandise = '$data_merch[id_merchandise]'");
                
                mysqli_query($conn, "update merchandise_pembelian set catatan = '$catatan', status = 'Menunggu konfirmasi admin' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]' ");

                mysqli_query($conn, "update tujuan_pengiriman set nama_penerima = '$penerima', tlp = '$tlp', alamat = '$alamat', kota = '$kota' where id_anggota = '$data_user[id_anggota]'");
                
                echo "<script type ='text/javascript'>alert('Bukti transfer berhasil diubah');</script>";
                echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";
            } else if ($data_pembelian['status'] != 'Ditolak') {
                //update bukti sebelum dikonfirmasi admin
                mysqli_query($conn, "update merchandise_pembelian set catatan = '$catatan', status = 'Menunggu konfirmasi admin' where id_pembelian_merch = '$id' and id_anggota = '$data_user[id_anggota]' ");
                querydb($edit_status_pembelian);
                
                mysqli_query($conn, "update tujuan_pengiriman set nama_penerima = '$penerima', tlp = '$tlp', alamat = '$alamat', kota = '$kota' where id_anggota = '$data_user[id_anggota]' ");

                echo "<script type ='text/javascript'>alert('Bukti transfer berhasil diubah');</script>";
                echo "<meta http-equiv='refresh' content='0;url=anggota-pembayaran-merch.php?id=".$id."'>";
            }
        
          
        } else {
            echo "<script type ='text/javascript'>alert('Bukti transfer gagal tersimpan');</script>";
        }
    }
    
        
}

?>

  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Check Out Pembelian Merchandise</h2>
          <ol>
            <li><a href="anggota-home.php">Home</a></li>
            <li><a href="anggota-merchandise.php">Merchandise</a></li>
            <li>Check Out Pembelian Merchandise</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Iuran yang belum dibayarkan ======= -->
    <section >
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <table class="mb-3">
                    <tbody>
                        <tr>
                            <td><strong>Harga Per Merchandise</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;Rp <?php echo number_format($data_pembelian['harga_satuan'],0,',','.') ?> </td> 
                        </tr>
                        <tr>
                            <td><strong>Jumlah Yang Dibeli</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['jumlah'] ?> <button <?php if ($data_pembelian['status'] != 'Belum dibayar') { echo "style='display:none;'"; } ?> data-toggle="modal" data-target="#pembelian" class="btn btn-link"><i class="fa fa-edit"></i>&nbsp; Edit</button> </td> 
                        </tr>
                        <tr>
                            <td><strong>Harga Total</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<strong><h5>Rp <?php echo number_format($data_pembelian['total_harga'],0,',','.') ?></h5></strong> </td> 
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
                            <td><strong>Status</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['status'] ?> </td> 
                        </tr>
                        <tr <?php if ($data_pembelian['status'] == 'Menunggu konfirmasi admin') { echo "style='display:none;'"; } ?>>
                            <td><strong>Unggah Bukti Sebelum</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $kadaluarsa ?> </td> 
                        </tr>
                        <tr <?php if ($data_pembelian['status'] != 'Ditolak') { echo "style='display:none;'"; } ?>>
                            <td><strong>Alasan Penolakan</strong></td> 
                            <td>&nbsp; : </td> 
                            <td>&nbsp;<?php echo $data_pembelian['alasan_penolakan'] ?> </td> 
                        </tr>
                    </tbody>
                  </table>
                  
                  <div  style="<?php if ($data_iuran['status'] == 'Terkonfirmasi') { echo "display:none"; } ?>">
                  <h4>Tata cara pembayaran</h4>
                  <?php echo $data_pembayaran['tata_cara'] ?>
                  
              </div>
              </div>
              <div class="col-lg-6">
                  <form action="" method="post" enctype="multipart/form-data">
                      <h4>Data Pengiriman</h4>
                      <div class="form-group"> 
                        Alamat
                        <textarea class="form-control " placeholder="Alamat pengiriman" name="alamat" rows="3" required><?php echo $data_tujuan['alamat'] ?></textarea>
                      </div>
                      <div class="form-group"> 
                        Kota
                        <input type="text" class="form-control " placeholder="Kota tujuan" name="kota" value="<?php echo $data_tujuan['kota'] ?>" required>
                      </div>
                      <div class="form-group"> 
                        Nama Penerima
                        <input type="text" class="form-control " placeholder="Penerima" name="penerima" value="<?php echo $data_tujuan['nama_penerima'] ?>" required>
                      </div>
                      <div class="form-group"> 
                        Nomor Telepon Penerima
                        <input type="text" class="form-control " placeholder="Nomor telepon penerima" value="<?php echo $data_tujuan['tlp'] ?>" name="tlp" required>
                      </div>
                      <div class="form-group"> 
                        Catatan
                        <input type="text" class="form-control " placeholder="Catatan tambahan" name="catatan" value="<?php echo $data_pembelian['catatan'] ?>">
                      </div>
                    <h4 class="mt-4">Bukti Transfer</h4>

                  
                    <div style=" overflow:hidden;">
                        <img class="card-img-top" id="output" style="min-height:300px; min-width:100px; " src="<?php if ($data_bukti == '') { echo 'assets/img/default.jpg'; } else { echo 'bukti-merch/'.$data_bukti['nama_foto_bukti_merch']; } ?>">
                    </div>
                    <input class="custom-file" type="file"  onchange="loadFile(event)" name="bukti" <?php if ($data_pembelian['status'] == 'Belum dibayar') { echo "required='required'"; } ?> >
                    <div class="text-center ">
                      <button type="submit" name="action" value="simpan bukti" class="btn btn-primary btn-block btn-icon-split"><i class="fa fa-save"></i><span class="text">&nbsp;Simpan</span></button>
                    </div>
                  </form>
              </div>
              
          </div>
          
      </div>
    </section>
    <!-- End Iuran yang belum dibayarkan -->

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
                    <div class="col-md-12 offset-md-1">
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
                            <td><input type="number" name="jumlah" class="form-control col-md-6" max="<?php echo $stok ?>" value="<?php echo $data_pembelian['jumlah'] ?>" required></td> 
                        </tr>
                    </table>
                            </center>
                    </div>
                    <input type="text" class="form-control" name="id" value="<?php echo $data_merch['id_merchandise']; ?>" style="display:none">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" name="action" value="simpan data" type="submit">Simpan</button>
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