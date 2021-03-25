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
        if($user->_is_logged_as('lekarz'))
        {
            $ans = $user->execute_sql("SELECT o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, o.osoba_adres, p.pacjent_stan FROM projekt.osoba o LEFT JOIN projekt.pacjent p ON p.osoba_pesel = o.osoba_pesel WHERE o.wojewodztwo_ID = (SELECT os.wojewodztwo_ID FROM projekt.osoba os, projekt.lekarz lek WHERE lek.osoba_pesel = os.osoba_pesel AND lek.lekarz_id = {$_SESSION['lekarz']}) AND (p.pacjent_stan IS NULL OR p.pacjent_stan = 'ozdrowiały') ORDER BY o.osoba_nazwisko, o.osoba_imie");
            
            echo "<h2>Nałóż kwarantannę na pacjenta</h2>";
            
            echo "<form name=\"stan\" method=\"post\" onsubmit=\"return confirm('Czy potwierdzasz tę akcję?');\" action=\"lekarz_quarantine.php\">
            <h3>Jak to zrobić?</h3>
            Wybierz pacjenta z listy, na którego ma zostać nałożona kwarantanna:<br><br>
            <select name=\"kto\" size=\"10\">";
            while($row = pg_fetch_row($ans))
            {
                echo "<option value=\"".$row[0]."\">";
                $txt = "";
                for($it = 1; $it < count($row) - 1; $it++)
                {
                    $txt .= $row[$it].", ";
                }
                if($row[count($row)-1])
                {
                    $txt .= $row[count($row)-1];
                }
                else
                {   
                    $txt .= "zdrowy/a";
                }
                echo $txt."</option>";
            }
            echo "</select>
            <br><br>
            <input type=\"submit\" value=\"Nałóż kwarantannę\" style=\"font-size: 24px;\">
            </form>
            <br>
            <a class=\"button\" href=\"lekarz_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>