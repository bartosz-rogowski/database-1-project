<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Nałóż kwarantannę
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
            $ans = $user->execute_sql("INSERT INTO projekt.pacjent(Osoba_Pesel, Pacjent_Stan) VALUES('{$_POST['kto']}', 'kwarantanna')");
            if($ans)
            {
                echo "<script>alert('Kwarantanna została nałożona poprawnie.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego kwarantanna NIE została nałożona. Spróbuj ponownie.');</script>";
            }
            echo "<a class=\"button\" href=\"lekarz_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";

        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>