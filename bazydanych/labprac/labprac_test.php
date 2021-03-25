<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Wprowadź wynik testu
    </title>
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>

<body>
    <div id="container">
        
        <?php 
        include '../Register.php';
        $user = new Register;
        if($user->_is_logged_as('lab'))
        {
            $ans = $user->execute_sql("INSERT INTO projekt.test(Zlecenie_Testu_ID, Pracownik_Laboratorium_ID, Test_Wynik, Test_Data) VALUES({$_POST['zlecenie']}, {$_SESSION['lab']},'{$_POST['wynik']}', NOW()::DATE)");
            if($ans)
            {
                echo "<script>alert('Zapisano wynik testu.');</script>";
            }
            else
            {
                echo "<script>alert('Nastąpił problem, w wyniku którego wynik testu NIE został zapisany.');</script>";
            }
            echo "<br><br>
            <a class=\"button\" href=\"labprac_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>