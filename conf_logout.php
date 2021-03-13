<?php
session_start();

include "conf_config.php";

function redirect($url){
	echo "<script language='javascript'>window.location.href='".$url."'</script>";
}

$username = $_POST['username'];
$passwd = $_POST['password'];

$url="login-anggota.php";

$tgl = date("Y-m-d");
$jam = date("H:i:s");		
mysqli_query($conn, "	UPDATE log_akses_anggota SET tgl_log_out='$tgl', jam_log_out='$jam', status='2' WHERE username = '$_SESSION[username]' AND status ='1' ");
unset($_SESSION['username']);
			
if(session_destroy()) {
    echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
} else {
    echo "<script type ='text/javascript'>alert('Gagal log out, silahkan coba lagi');</script>";
}
		
?>