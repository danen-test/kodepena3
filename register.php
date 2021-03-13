<?php
include "conf_config.php";

error_reporting(0);

$tgl = date("Y-m-d");
$bln_thn = date("my");
$bln = date("m");
$thn = date("Y");

$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$username = $_POST['username'];
$pass1 = md5($_POST['pass1']);
$pass2 = md5($_POST['pass2']);
$email = $_POST['email'];
$tlp = $_POST['tlp'];
$action = $_POST['action'];

if ($action == 'simpan data') {
    $query_cek_username = mysqli_query($conn, "select * from anggota where username_anggota = '$username'");
    $cek_username = mysqli_num_rows($query_cek_username);
    if ($pass1 != $pass2) {
        echo "<script type ='text/javascript'>alert('Password yang anda masukkan tidak sama');</script>";
    } else if ($pass1 == $pass2) {
        if ($cek_username > 0) {
        echo "<script type ='text/javascript'>alert('Username tersebut sudah digunakan, silahkan masukkan username lain');</script>";
        } else if ($cek_username == 0) {
            $query_jumlah_anggota = mysqli_query($conn, "select * from anggota where month (tgl_registrasi) = '$bln' and year (tgl_registrasi) = '$thn'");
            $jumlah_anggota = mysqli_num_rows($query_jumlah_anggota);
            $id = "AA".$bln_thn.($jumlah_anggota + 10001); // AA = Anggota

            mysqli_query($conn, "insert into anggota (id_anggota, username_anggota, password, nama_depan, nama_belakang, email, tlp, tgl_registrasi, status, hak_akses) values ('$id', '$username', '$pass1', '$nama_depan', '$nama_belakang', '$email', '$tlp', '$tgl', 'aktif', '2')");

            echo "<script type ='text/javascript'>alert('Data berhasil tersimpan, silahkan log in');</script>";
            echo "<meta http-equiv='refresh' content='0;url=login-anggota.php'>";
        } else {
            echo "<script type ='text/javascript'>alert('Data gagal tersimpan, silahkan coba beberapa saat lagi');</script>";
        }
    }
    
}

$query_data_komunitas = mysqli_query($conn, "select * from data_komunitas");
$data_komunitas = mysqli_fetch_assoc($query_data_komunitas);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $data_komunitas['nama_komunitas']; ?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-color:#37517e;">

    <div class="container col-xl-6 col-lg-7 col-md-5">

        <div class="card o-hidden border-0 shadow-lg my-5 ">
            <div class="card-body p-0 ">
                <!-- Nested Row within Card Body -->
                <div class="row justify-content-center ">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Registrasi Anggota</h1>
                            </div>
                            <form class="user" action="" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="nama_depan" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nama Depan">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="nama_belakang" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Nama Belakang">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="username" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" name="tlp" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nomor Telepon" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email" name="email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="pass1" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="pass2" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Ulangi Password" required>
                                    </div>
                                </div>
                                <button type="submit" name="action" value="simpan data" class="btn btn-primary btn-user btn-block">
                                    Registrasi
                                </button>
                                
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login-anggota.php">Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>

</body>

</html>