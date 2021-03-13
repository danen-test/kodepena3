<?php
session_start();
include "conf_config.php";


$username=$_POST['username'];
$passwd=md5($_POST['password']);

global $username;

$url="login-anggota.php";
$url_anggota="anggota-home.php";

$data_login= mysqli_query($conn, "SELECT * FROM anggota WHERE username_anggota ='$username' AND password ='$passwd' and status = 'aktif'");
$cek_login= mysqli_num_rows($data_login);

if ($username == "") 
	{
        echo "<script type ='text/javascript'> alert('Login Gagal, Isikan Username dan Password Dengan Benar');</script>";
        echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
	} else if ($cek_login > 0) {
        $data_pengguna = mysqli_fetch_assoc($data_login);
        if ($data_pengguna['hak_akses'] == 2) {
            $_SESSION['username'] = $data_pengguna['username_anggota'];
            $_SESSION['hak_akses'] = "2";
            $jam = date("H:i:s");
            $tgl = date("Y-m-d");

            mysqli_query($conn, "INSERT INTO log_akses_anggota(username ,tgl_login, jam_login, status) VALUES('$_SESSION[username]','$tgl','$jam','1')");
            header("location:".$url_anggota);
            exit();
        } else {
            unset($_SESSION['username']);
            echo "<script type ='text/javascript'>alert('Login Gagal,Pastikan User Anda Sudah Aktif');</script>"; 
            header("location:".$url);
            exit();
        }
        

    } else if ($cek_login == 0) {
        unset($_SESSION['username']);
        echo "<script type ='text/javascript'>alert('Login Gagal,Pastikan User Anda Sudah Aktif');</script>"; 
        header("location:".$url);
        exit();
    }


?>