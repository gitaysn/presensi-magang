<?php 

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM bidang WHERE id=$id");

$_SESSION['berhasil'] = 'Data berhasil dihapus';
header("Location: bidang_penempatan.php");
exit;

include('../layout/footer.php');
