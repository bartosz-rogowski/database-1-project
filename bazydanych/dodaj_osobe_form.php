<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Stwórz swoje nowe konto
    </title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <div id="container">
        <h2>Podaj swoje dane osobowe</h2>
        <form id="rep" method="post" action="dodaj_osobe.php">
            Podaj swój PESEL:<br>
            <input type="text" name="pesel" pattern="[0-9]{12}" title="Pesel składa się z 12 cyfr"><br><br>
            Podaj swoje imię:<br>
            <input type="text" name="imie" pattern=".{3,}"><br><br>
            Podaj swoje nazwisko:<br>
            <input type="text" name="nazwisko" pattern=".{3,}"><br><br>
            Podaj swoje miasto, w którym jesteś zameldowany/a:<br>
            <input type="text" name="miasto" pattern=".{3,}"><br><br>
            Podaj nazwę ulicy oraz numer mieszkania:<br>
            <input type="text" name="adres" pattern=".{3,}"><br><br>
            Podaj swój numer telefonu:<br>
            <input type="text" name="telefon" pattern="[0-9]{9}"><br><br>
            Podaj swoje hasło do serwisu:<br>
            <input type="text" name="haslo" pattern=".{7,}" title="W celach bezpieczeństwa zaleca się użycie hasła z co najmniej 7 znakami."><br><br>
            Wybierz z listy swoje województwo:<br>
            <select name="wojew" size="1">
            <?php 
                include 'Register.php';
                $user = new Register;
                $ans = $user->execute_sql("SELECT wojewodztwo_ID, wojewodztwo_nazwa FROM projekt.wojewodztwo");
                $rows = pg_fetch_all($ans);
                foreach($rows as $row)
                {
                    echo "<option value=\"".$row['wojewodztwo_id']."\">".$row['wojewodztwo_nazwa']."</option>";
                }
            ?>
            </select><br><br>
            <input type="submit" name="submit" value="Stwórz konto" style="font-size: 24px;" onclick="return confirm('Czy potwierdzasz poprawność podanych danych?')">
        </form><br><br>
    </div>
</body>

</html>