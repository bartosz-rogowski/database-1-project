<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Wyświetl raport
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">

        <?php
        include '../Register.php';
        $user = new Register;
        if ($user->_is_logged_as('sanepid')) {
            $user->execute_sql("CREATE OR REPLACE VIEW projekt.widok_raportow AS SELECT o.osoba_pesel, o.osoba_imie, o.osoba_nazwisko, o.osoba_telefon, o.osoba_miasto, o.osoba_adres, w.wojewodztwo_nazwa, z.zakazony_data_wpisu, z.zakazony_miejsce_kwarantanny, p.szpital_id FROM projekt.osoba o LEFT JOIN projekt.pacjent p ON p.osoba_pesel = o.osoba_pesel JOIN projekt.zakazeni z ON p.pacjent_id = z.pacjent_id JOIN projekt.wojewodztwo w ON o.wojewodztwo_ID = w.wojewodztwo_ID JOIN projekt.sanepid s ON s.wojewodztwo_ID = w.wojewodztwo_ID");
            echo "<h2>Raporty</h2>";

            echo "<form id=\"rep\" method=\"post\" >
                Wybierz przedział czasowy dla raportu:<br><br>
                <input type=\"radio\" name=\"period\" value=\"1 day\" onclick=\"this.form.submit();\"> Raport z dziś<br>
                <input type=\"radio\" name=\"period\" value=\"30 days\" onclick=\"this.form.submit();\"> Raport z ostatnich 30 dni<br>
                <input type=\"radio\" name=\"period\" value=\"all\" onclick=\"this.form.submit();\"> Raport z całego okresu<br><br>
                <input type=\"submit\" name=\"submit\" value=\"Pokaż raport\" style=\"font-size: 24px;\">
            </form><br><br>";
            
            $query = "SELECT wojewodztwo_nazwa, count(*) FROM projekt.widok_raportow";
            if (isset($_POST['submit'])) 
            {
                if (!empty($_POST['period'])) 
                {
                    if($_POST['period'] != "all")
                    {
                        $query .= " WHERE zakazony_data_wpisu between (NOW() - interval '{$_POST['period']}') AND NOW()";
                    }
                    $query .= " GROUP BY wojewodztwo_nazwa HAVING count(*) > 0";
                }
                $ans = $user->execute_sql($query);
                if($ans)
                {
                    echo "<table>
                    <tr>
                        <th>Województwo</th>
                        <th>Łączna liczba zakażonych</th>
                    </tr>";
                    while ($row = pg_fetch_row($ans)) 
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