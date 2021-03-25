<?php
include '../Register.php';
$user = new Register;
if($_POST['login'] != "" && $_POST['pass'] != "")
    $user->_login_as('lab');
else
    header("Location: labprac_log.html");
?>
