<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Osoba
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('osoba'))
        {
            $ans = $user->execute_sql("SELECT osoba_imie FROM projekt.osoba WHERE osoba_pesel = '{$_SESSION['osoba']}'");
            $row = pg_fetch_row($ans);
            echo "<h2>Witaj ".$row[0]."!</h2>"; 
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        <br>
        <nav>
            <ul>
                <li>
                    <a href="osoba_info.php" title="Informacje">Wyświetl informacje</a>
                </li>
                <li>
                    <a href="osoba_change_pass_form.php" title="Zmień hasło do tego konta">Zmień hasło</a>
                </li>
                <li>
                    <a href="osoba_contact_form.php" title="Edytuj swoje dane kontaktowe">Edytuj dane kontaktowe</a>
                </li>
                <li>
                    <a href="osoba_test_req.php" title="Zapisz się na test" onclick="return confirm('Czy na pewno chcesz zlecić przeprowadzenie testu?');">Zgłoś zapis na test</a>
                </li>
            </ul>
        </nav>
        <a class="button" href="../logout.php" title="Wyloguj się">Wyloguj</a>
    </div>
</body>

</html>