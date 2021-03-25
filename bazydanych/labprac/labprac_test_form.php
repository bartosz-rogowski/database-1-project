<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Wprowadź wynik testu
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
            $ans = $user->execute_sql("select z.zlecenie_testu_id, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, o.wojewodztwo_id, z.zlecenie_testu_data from projekt.zlecenie_testu z JOIN projekt.osoba o ON z.osoba_pesel = o.osoba_pesel WHERE zlecenie_testu_id NOT IN (SELECT zlecenie_testu_id FROM projekt.test) ORDER BY o.osoba_nazwisko, o.osoba_imie");
            echo "<h2>Wpisz wyniki testu</h2>";
            echo  "<form name=\"test\" method=\"post\" onsubmit=\"return confirm('Czy potwierdzasz tę akcję?');\" action=\"labprac_test.php\">
            <h3>Jak to zrobić?</h3>
            Wybierz zlecenie testu, którego wynik chcesz wpisać do bazy:<br><br>
            <select name=\"zlecenie\" size=\"5\">";
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
            Wynik testu:<br>
            <select name=\"wynik\" size=\"1\">
            <option value=\"TRUE\">pozytywny</option>
            <option value=\"FALSE\">negatywny</option></select><br><br><br>
            <input type=\"submit\" value=\"Zapisz wynik testu\" style=\"font-size: 24px;\">
            </form>
            <br>
            <br>
            <a class=\"button\" href=\"labprac_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>