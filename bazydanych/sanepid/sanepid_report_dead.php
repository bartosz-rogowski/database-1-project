<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Wyświetl raport zmarłych
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">

        <?php
        include '../Register.php';
        $user = new Register;
        if ($user->_is_logged_as('sanepid')) {
            $user->execute_sql("CREATE OR REPLACE VIEW projekt.widok_zgonow AS SELECT o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_miasto, o.wojewodztwo_id, extract(year from z.zgon_data_zgonu) - ('19'||(SUBSTR(o.osoba_pesel, 1, 2)))::INTEGER AS wiek FROM projekt.osoba o JOIN projekt.pacjent p ON p.osoba_pesel = o.osoba_pesel JOIN projekt.zmarli z ON p.pacjent_id = z.pacjent_id");
            echo "<h2>Raport o osobach zmarłych</h2>";

            echo "<form id=\"rep\" method=\"post\">
                Wybierz przedział czasowy dla raportu:<br><br>
                <input type=\"radio\" name=\"type\" value=\"one\"> Raport zmarłych z tego województwa<br>
                <input type=\"radio\" name=\"type\" value=\"all\"> Raport zmarłych z całego kraju<br><br>
                <input type=\"submit\" name=\"submit\" value=\"Pokaż raport\" style=\"font-size: 24px;\" onclick=\"this.form.submit();\">
            </form><br><br>";
            
            $query = "SELECT * FROM projekt.widok_zgonow";
            if (isset($_POST['submit']) && isset($_POST['type'])) 
            {
                if (!empty($_POST['type'])) 
                {
                    if($_POST['type'] != "all")
                    {
                        $query .= " WHERE wojewodztwo_ID = (SELECT s.wojewodztwo_ID FROM projekt.sanepid s WHERE s.sanepid_id = {$_SESSION['sanepid']})";
                    }
                }
                $ans = $user->execute_sql($query);
                $rows = pg_fetch_all($ans);
                if($rows[0])
                {
                    echo "<table>
                    <tr>
                        <th>Pesel</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Miasto</th>
                        <th>Skrót województwa</th>
                        <th>Wiek</th>
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
                    echo "</table><br><span style=\"display: block; background-color: white; text-align: center;\">Łącznie osób: ".count($rows)."</span>";
                }
                else
                    echo "<span class=\"blad\">Brak danych</span>";
            }
            else
                echo "<span class=\"blad\">Wypełnij przynajmniej jedno pole.</span>";

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