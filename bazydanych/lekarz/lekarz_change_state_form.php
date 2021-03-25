<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Zmień stan pacjenta
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
            $ans = $user->execute_sql("SELECT p.pacjent_id, o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, p.pacjent_stan, p.szpital_id FROM projekt.osoba o, projekt.pacjent p WHERE o.osoba_pesel = p.osoba_pesel AND p.pacjent_stan NOT LIKE 'nie żyje' ORDER BY o.osoba_nazwisko, o.osoba_imie");
            
            echo "<h2>Zmień stan pacjenta</h2>";
            
            echo "<form name=\"stan\" method=\"post\" onsubmit=\"return confirm('Czy potwierdzasz tę akcję?');\" action=\"lekarz_change_state.php\">
            <h3>Jak to zrobić?</h3>
            Wybierz pacjenta z listy, a następnie przypisz mu nowy stan<br><br>
            <select name=\"kto\" size=\"4\">";
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
                    $txt .= "brak przyporządkowania do szpitala";
                }
                echo $txt."</option>";
            }
            echo "</select><br><br>Podaj nowy stan pacjenta:<br>
            <select name=\"stan\" size=\"1\">
            <option value = \"chory\">chory</option>
            <option value = \"ozdrowiały\">ozdrowiały</option>
            <option value = \"kwarantanna\">kwarantanna</option>
            <option value = \"nie żyje\">nie żyje</option></select>
            <br><br><br><br><br>
            <input type=\"submit\" value=\"Zmień stan\" style=\"font-size: 24px;\">
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