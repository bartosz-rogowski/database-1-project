<?php
include '../Register.php';
$user = new Register;
if($_POST['login'] != "" && $_POST['pass'] != "")
    $user->_login_as('osoba');
else
    header("Location: osoba_log.html");
?>
