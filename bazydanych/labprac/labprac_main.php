<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Pracownik Laboratorium - strona główna
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('lab'))
        {
            $ans = $user->execute_sql("SELECT o.osoba_imie FROM projekt.osoba o, projekt.pracownik_laboratorium p where p.osoba_pesel = o.osoba_pesel AND p.pracownik_laboratorium_id = '{$_SESSION['lab']}'");
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
                    <a href="labprac_test_form.php" title="Informacje">Uzupełnij wyniki testu</a>
                </li>
                <li>
                    <a href="labprac_change_pass_form.php" title="Zmień hasło do tego konta">Zmień hasło</a>
                </li>
            </ul>
        </nav>
        <a class="button" href="../logout.php" title="Wyloguj się">Wyloguj</a>
    </div>
</body>

</html>