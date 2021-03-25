<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Sanepid - strona główna
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('sanepid'))
        {
            $ans = $user->execute_sql("SELECT w.wojewodztwo_nazwa from projekt.sanepid s JOIN projekt.wojewodztwo w ON s.wojewodztwo_id = w.wojewodztwo_id WHERE s.sanepid_id = {$_SESSION['sanepid']}");
            $row = pg_fetch_row($ans);
            echo "<h2>Wojewódzka stacja sanitarno-epidemiologiczna<br>województwo ".$row[0]."</h2>"; 
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        <br>
        <nav>
            <ul>
                <li>
                    <a href="sanepid_report_days.php" title="Raport z ostatnich dni">Zakażeni (województwo)</a>
                </li>
                <li>
                    <a href="sanepid_report_all.php" title="Raport z całej Polski">Zakażeni (cały kraj)</a>
                </li>
                <li>
                    <a href="sanepid_report_dead.php" title="Raport o osobach zmarłych">Raport o zmarłych</a>
                </li>
                <li>
                    <a href="sanepid_report_recovered.php" title="Raport o osobach, które wyzdrowiały">Raport o ozdrowieńcach</a>
                </li>
                <li>
                    <a href="sanepid_isolation_form.php" title="Skieruj osobę na izolację">Skieruj na izolację</a>
                </li>
                <li>
                    <a href="sanepid_change_pass_form.php" title="Zmień hasło do tego konta">Zmień hasło</a>
                </li>
                <li>
                    <a href="sanepid_find.php" title="Wyszukaj informacje o danej osobie">Wyszukaj osobę</a>
                </li>
            </ul>
        </nav>
        <a class="button" href="../logout.php" title="Wyloguj się">Wyloguj</a>
    </div>
</body>

</html>