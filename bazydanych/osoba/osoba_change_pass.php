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
        if($user->_is_logged_as('osoba'))
        {
            $ans = $user->execute_sql(" UPDATE projekt.osoba SET osoba_haslo='{$_POST['new_pass']}' WHERE osoba_pesel = '{$_SESSION['osoba']}'");
            if($ans)
            {
                echo "<script>alert('Hasło zostało zmienione.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego hasło NIE zostało zmienione.');</script>";
            }
            echo "<a class=\"button\" href=\"osoba_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";

        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>