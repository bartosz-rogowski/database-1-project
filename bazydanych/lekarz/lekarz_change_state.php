<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Zmień stan
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
            $ans = $user->execute_sql("UPDATE projekt.pacjent SET pacjent_stan='{$_POST['stan']}' WHERE pacjent_id = {$_POST['kto']}");
            if($ans)
            {
                echo "<script>alert('Stan został zmieniony.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego stan NIE został zmieniony.');</script>";
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