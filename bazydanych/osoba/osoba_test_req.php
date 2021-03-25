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
            $ans = $user->execute_sql(" INSERT INTO projekt.zlecenie_testu(Osoba_Pesel, Zlecenie_Testu_Data) VALUES ('{$_SESSION['osoba']}', NOW())");
            if($ans)
            {
                echo "<script>alert('Zlecenie przyjęte.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego zlecenie nie zostało przyjęte. Spróbuj ponownie.');</script>";
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