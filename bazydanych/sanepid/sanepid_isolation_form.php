<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Nałóż kwarantannę na pacjenta
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
            $ans = $user->execute_sql("SELECT o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, o.osoba_adres FROM projekt.osoba o WHERE o.wojewodztwo_ID = (SELECT s.wojewodztwo_ID FROM projekt.sanepid s WHERE s.sanepid_id = {$_SESSION['sanepid']}) ORDER BY o.osoba_nazwisko, o.osoba_imie");
            
            echo "<h2>Izoluj osobę</h2>";
            
            echo "<form name=\"izolacja\" method=\"post\" onsubmit=\"return confirm('Czy potwierdzasz tę akcję?');\" action=\"sanepid_isolation.php\">
            <h3>Jak to zrobić?</h3>
            Wybierz osobę z listy, która ma zostać skierowana na izolację do wybranej z drugiej listy placówki:<br><br>
            <select name=\"kto\" size=\"5\">";
            while($row = pg_fetch_row($ans))
            {
                echo "<option value=\"".$row[0]."\">";
                $txt = "";
                for($it = 0; $it < count($row) - 1; $it++)
                {
                    $txt .= $row[$it].", ";
                }
                $txt .= $row[count($row)-1];
                echo $txt."</option>";
            }
            echo "</select><br><br>
            <select name=\"gdzie\" size=\"4\">";
            $ans = $user->execute_sql("SELECT * FROM projekt.izolatorium");
            while($row = pg_fetch_row($ans))
            {
                echo "<option value=\"".$row[0]."\">";
                $txt = "";
                for($it = 1; $it < count($row) - 1; $it++)
                {
                    $txt .= $row[$it].", ";
                }
                $txt .= $row[count($row)-1];
                echo $txt."</option>";
            }
            echo "</select><br><br>
            <input type=\"submit\" value=\"Skieruj na izolację\" style=\"font-size: 24px;\">
            </form>
            <br>
            <a class=\"button\" href=\"sanepid_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>