<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Lekarz - strona główna
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('lekarz'))
        {
            $ans = $user->execute_sql("SELECT o.osoba_imie FROM projekt.osoba o, projekt.lekarz l where l.osoba_pesel = o.osoba_pesel AND l.lekarz_id = '{$_SESSION['lekarz']}'");
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
                    <a href="lekarz_change_state_form.php" title="Informacje">Zmień stan pacjenta</a>
                </li>
                <li>
                    <a href="lekarz_change_pass_form.php" title="Zmień hasło do tego konta">Zmień hasło</a>
                </li>
                <li>
                    <a href="lekarz_quarantine_form.php" title="Edytuj swoje dane kontaktowe">Nałóż kwarantannę</a>
                </li>
            </ul>
        </nav>
        <a class="button" href="../logout.php" title="Wyloguj się">Wyloguj</a>
    </div>
</body>

</html>