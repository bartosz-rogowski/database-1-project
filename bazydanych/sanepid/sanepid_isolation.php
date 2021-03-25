<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Zmień hasło
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('sanepid'))
        {
            $ans = $user->execute_sql("select projekt.dodaj_izolacje('{$_POST['kto']}', '{$_POST['gdzie']}', NOW()::DATE)");
            if($ans)
            {
                echo "<script>alert('Nałożono izolację.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego izolacja NIE została nałożona.');</script>";
            }
            echo "<a class=\"button\" href=\"sanepid_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";

        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>