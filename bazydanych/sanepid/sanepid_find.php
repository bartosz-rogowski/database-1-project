<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Znajdź osobę
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">

        <?php
        include '../Register.php';
        $user = new Register;
        if ($user->_is_logged_as('sanepid')) {
            echo "<h2>Znajdź osobę i jej dane</h2>";

            echo "<form id=\"find\" method=\"post\" >
                Wskazówka: Nie musisz uzupełniać wszystkich pól<br><br>
                Podaj pesel:
                <input type=\"text\" name=\"pesel\"><br><br>
                Podaj imię:
                <input type=\"text\" name=\"imie\"><br><br>
                Podaj nazwisko:
                <input type=\"text\" name=\"nazwisko\"><br><br>
                <input type=\"submit\" name=\"submit\" value=\"Znajdź osobę\" style=\"font-size: 24px;\" onclick=\"this.form.submit();\">
            </form><br><br>";
            
            $imie = "%";
            $nazwisko = "%";
            $pesel = "%";
            if (isset($_POST['submit']) && ($_POST['imie'] != "" || $_POST['nazwisko'] != "" || $_POST['pesel'] != "")) 
            {
                if ($_POST['imie'] != "") 
                {
                    $imie = $_POST['imie'];
                }
                
                if ($_POST['nazwisko'] != "") 
                {
                    $nazwisko = $_POST['nazwisko'];
                }
                
                if ($_POST['pesel'] != "") 
                {
                    $pesel = $_POST['pesel'];
                }
                $ans = $user->execute_sql("SELECT o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, o.osoba_adres, w.wojewodztwo_nazwa, o.osoba_telefon, o.kontaktowa_osoba_pesel FROM projekt.osoba o, projekt.wojewodztwo w WHERE osoba_pesel LIKE '{$pesel}' AND osoba_imie LIKE '{$imie}' AND osoba_nazwisko LIKE '{$nazwisko}' AND o.wojewodztwo_id = w.wojewodztwo_id ORDER BY osoba_nazwisko, osoba_imie, osoba_pesel");
                $rows = pg_fetch_all($ans);
                if(count($rows[0]) > 0)
                {
                    echo "<table>
                    <tr>
                        <th>Pesel</th>
                        <th>Imie</th>
                        <th>Nazwisko</th>
                        <th>Miasto</th>
                        <th>Adres</th>
                        <th>Województwo</th>
                        <th>Numer telefonu</th>
                        <th>Pesel osoby kontaktowej</th>
                    </tr>";
                    foreach($rows as $row) 
                    {
                        echo "<tr>";
                        foreach($row as $it)
                        {
                            echo "<td>{$it}</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table><br>";
                }
                else{
                    echo "<span class=\"blad\">Nie znaleziono rekordów o zadanych parametrach.</span>";
                }
            }
            else{
                echo "<span class=\"blad\">Wypełnij przynajmniej jedno pole.</span>";
            }
            echo "<br><br>
            <a class=\"button\" href=\"sanepid_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        } 
        else 
        {
            header("Location: ../index.html");
        }

        ?>

    </div>
</body>

</html>