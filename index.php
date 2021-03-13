<?php
//Memanggil header
include "header.php";
//End Memanggil header

?>



      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li><a href="merchandise.php">Merchandise</a></li>
          <li><a href="login-anggota.php">Log In</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Welcome to <span><?php echo $data_komunitas["nama_komunitas"]; ?></span>
      </h1>
      <h2><?php echo $data_komunitas['deskripsi_singkat']; ?></h2>
      <div class="d-flex">
        <a href="#about" class="btn-get-started scrollto">Get Started</a>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg">
      <div class="container col-md-6" data-aos="fade-up">

        <div class="section-title">
          <h2>About</h2>
          <h3>Tentang Kami</h3>
        </div>
        
        <center>
            <div class="row">
              <div  data-aos="fade-up" data-aos-delay="100">
                <p>
                  <?php echo $data_komunitas['deskripsi_lengkap']; ?>
                </p>
              </div>
            </div>
        </center>
        

      </div>
    </section><!-- End About Section -->


    <!-- ======= News Section ======= -->
    <section id="team" class="team ">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Berita</h2>
          <h3>Berita Komunitas Kami</h3>
          
        </div>

        <div class="row">

          <?php 
            $query_data_berita = mysqli_query($conn, "select * from berita where status = 'Ditampilkan' order by tgl_berita desc limit 6");
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


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container col-md-7" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <h3><span>Contact Us</span></h3>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-4 col-md-4">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p><?php echo $data_komunitas['alamat']; ?></p>
            </div>
          </div>

          <div class="col-lg-4 col-md-4">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p><?php echo $data_komunitas['email']; ?></p>
            </div>
          </div>

          <div class="col-lg-4 col-md-4">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p><?php echo $data_komunitas['tlp']; ?></p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

<!-- Memanggil footer -->
<?php
include "footer.php";
?>
<!-- End Memanggil footer -->