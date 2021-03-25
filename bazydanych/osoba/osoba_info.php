<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Witaj
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('osoba'))
        {
            echo "<h2>Twoje dane osobowe:</h2>";
            $ans = $user->execute_sql("SELECT o.Osoba_Pesel, o.Osoba_Imie, o.Osoba_Nazwisko, o.Osoba_Miasto, o.Osoba_Adres, o.Osoba_Telefon, w.Wojewodztwo_Nazwa, p.pacjent_stan, sz.szpital_nazwa, iz.izolatorium_miasto, iz.izolatorium_adres FROM projekt.osoba o LEFT JOIN projekt.pacjent p ON p.osoba_pesel = o.osoba_pesel LEFT JOIN projekt.szpital sz ON p.szpital_id = sz.szpital_id LEFT JOIN projekt.izolacja i ON i.pacjent_id = p.pacjent_id LEFT JOIN projekt.izolatorium iz ON iz.izolatorium_id = i.izolatorium_id JOIN projekt.wojewodztwo w ON o.Wojewodztwo_ID = w.Wojewodztwo_ID WHERE o.Osoba_Pesel = '{$_SESSION['osoba']}'");
            $row = pg_fetch_row($ans);
            if($row)
            {
                echo "<table>
                <tr>
                    <th>Pesel</th>
                    <th>Imie</th>
                    <th>Nazwisko</th>
                    <th>Miasto</th>
                    <th>Adres</th>
                    <th>Telefon</th>
                    <th>Województwo</th>
                    <th>Stan</th>
                    <th>Szpital</th>
                    <th>Izolatorium - miasto</th>
                    <th>Izolatorium - adres</th>
                </tr>";

                echo "<tr>";
                foreach($row as $it)
                {
                    if($it)
                        echo "<td>{$it}</td>";
                    else 
                        echo "<td>-</td>";
                }
                echo "</tr>
                </table><br>";
                echo "<h2>Dane osób, które wyraziły zgodę na udzielanie informacji Tobie: </h2>";
                $answ = $user->execute_sql("SELECT o.Osoba_Pesel, o.Osoba_Imie, o.Osoba_Nazwisko, o.Osoba_Miasto, o.Osoba_Adres, o.Osoba_Telefon, w.Wojewodztwo_Nazwa, p.pacjent_stan, sz.szpital_nazwa, iz.izolatorium_miasto, iz.izolatorium_adres FROM (SELECT * FROM projekt.osoba WHERE kontaktowa_osoba_pesel = '{$_SESSION['osoba']}') AS o LEFT JOIN projekt.pacjent p ON p.osoba_pesel = o.osoba_pesel LEFT JOIN projekt.szpital sz ON p.szpital_id = sz.szpital_id LEFT JOIN projekt.izolacja i ON i.pacjent_id = p.pacjent_id LEFT JOIN projekt.izolatorium iz ON iz.izolatorium_id = i.izolatorium_id JOIN projekt.wojewodztwo w ON o.Wojewodztwo_ID = w.Wojewodztwo_ID");
                $rows = pg_fetch_all($answ);
                if(count($rows[0]) > 0)
                {
                    echo "<table>
                    <tr>
                        <th>Pesel</th>
                        <th>Imie</th>
                        <th>Nazwisko</th>
                        <th>Miasto</th>
                        <th>Adres</th>
                        <th>Telefon</th>
                        <th>Województwo</th>
                        <th>Stan</th>
                        <th>Szpital</th>
                        <th>Izolatorium - miasto</th>
                        <th>Izolatorium - adres</th>
                    </tr>";
                    foreach($rows as $row) 
                    {
                        echo "<tr>";
                        foreach($row as $it)
                        {
                            if($it)
                                echo "<td>{$it}</td>";
                            else 
                                echo "<td>-</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table><br>";
                }
            }
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        <br>
        
            
        <br>
        <a class="button" href="osoba_main.php" title="Wróć do strony głównej">Wróć do strony głównej</a>
    </div>
</body>

</html>