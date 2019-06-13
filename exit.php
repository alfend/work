<?php session_start();

$_SESSION['id_user'] = 'null';
header("Location: index.php");
exit();


?>
