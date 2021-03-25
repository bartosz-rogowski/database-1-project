<?php
include '../Register.php';
$user = new Register;
if($_POST['login'] != "" && $_POST['pass'] != "")
    $user->_login_as('lekarz');
else
    header("Location: lekarz_log.html");
?>
