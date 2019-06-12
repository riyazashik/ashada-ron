<?php
session_start();
if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] == '1'){
header("location:executedworks.php");
}
else{
header("location:login.php");
}
?>