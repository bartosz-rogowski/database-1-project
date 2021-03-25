<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Dodawanie osoby
    </title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include 'Register.php';
        $user = new Register;
        $imie = $_POST['imie'];
        $pesel = $_POST['pesel'];
        $nazwisko = $_POST['nazwisko'];
        $miasto = $_POST['miasto'];
        $adres = $_POST['adres'];
        $telefon = $_POST['telefon'];
        $haslo = $_POST['haslo'];
        $ans = $user->execute_sql("INSERT INTO projekt.osoba VALUES('{$pesel}', '{$imie}', '{$nazwisko}', '{$miasto}', '{$adres}', '{$telefon}', NULL, '{$haslo}', '{$_POST['wojew']}')");
        if($ans)
        {
            echo "<script>alert('Pomyślnie dodano nową osobę.');</script>";
        }
        else
        {
            echo "<script>alert('Nastąpił problem, w wyniku którego nie udało się dodać nowej osoby. Spróbuj ponownie.');</script>";
        }
        echo "<a class=\"button\" href=\"index.html\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        ?>
        
    </div>
</body>

</html>