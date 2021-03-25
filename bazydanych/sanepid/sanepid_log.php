<?php
include '../Register.php';
$user = new Register;
if($_POST['login'] != "" && $_POST['pass'] != "")
    $user->_login_as('sanepid');
else
    header("Location: sanepid_log.html");
?>
