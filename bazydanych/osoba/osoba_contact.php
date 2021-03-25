<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Zmień swoje dane kontaktowe
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
            if ($_POST['co'] != "" || $_POST['nowa'] != "") 
            {
                $ans;
                if ($_POST['co'] != "telefon") 
                {
                    $ans = $user->execute_sql("UPDATE projekt.osoba SET osoba_telefon='{$_POST['nowa']}' WHERE osoba_pesel = '{$_SESSION['osoba']}'");
                }
                
                if ($_POST['co'] != "osoba") 
                {
                    $ans = $user->execute_sql("SELECT projekt.edytuj_pesel_kontaktowej('{$_SESSION['osoba']}', '{$_POST['nowa']}')");
                }
                echo $ans;
                if($ans)
                    echo "<script>alert('Dane zostały zmienione.');</script>";
                else
                    echo "<script>alert('Nastąpił błąd, w wyniku którego dane NIE zostały zmienione. Wskazówka: Upewnij się, że dane, które zostały podane są odpowiednie i/lub nie zawierają niedozwolonych symboli');</script>";
            }
            else{
                echo "<script>alert('Formularz został błędnie wypełniony.');</script>";
            }
            echo "<br><br>
            <a class=\"button\" href=\"osoba_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>