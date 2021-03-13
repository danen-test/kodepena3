<!-- Memanggil header -->
<?php
include "header.php";
?>
<!-- End Memanggil header -->

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

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Berita</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Berita</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= News Section ======= -->
    <section id="team" class="team ">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Berita</h2>
          <h3>Berita Komunitas Kami</h3>
          
        </div>

        <div class="row">
            <?php 
            $query_data_berita = mysqli_query($conn, "select * from berita where status = 'Ditampilkan' order by tgl_berita desc");
            while ($data_berita = mysqli_fetch_assoc($query_data_berita)){
                $query_gambar = mysqli_query($conn, "select * from berita_gambar where id_berita = '$data_berita[id_berita]'");
                $gambar = mysqli_fetch_assoc($query_gambar);
            ?>
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" >
                <a href="detail-berita.php?id=<?=$data_berita['id_berita']?>">
                    <div class="member" style="height:330px">
                      <div class="member-img" style="max-width:100%; max-height:170px;  overflow:hidden;  ">
                        <img src="berita/<?php echo $gambar['nama_gambar_berita']; ?>" class="img-fluid" alt="" style="min-height:170px;">
                      </div>
                      <div class="member-info">
                        <h4><?php echo (str_word_count($data_berita['judul_berita']) > 9   ? substr($data_berita['judul_berita'],0,60)."..." : $data_berita['judul_berita']); ?></h4>
                        <span><?php echo (str_word_count($data_berita['isi_berita']) > 20   ? substr($data_berita['isi_berita'],0,150)."..." : $data_berita['isi_berita']); ?></span>
                      </div>
                    </div>
                </a>
            </div>
            <?php }; ?>
          

        </div>

      </div>
    </section><!-- End News Section -->

  </main><!-- End #main -->

<!-- Memanggil footer -->
<?php
include "footer.php";
?>
<!-- End Memanggil footer -->