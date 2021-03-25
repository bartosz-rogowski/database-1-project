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
            echo "<h2>Zmień swoje hasło do logowania</h2>";
            echo "<form name=\"haslo\" method=\"post\" action=\"sanepid_change_pass.php\">
            Podaj nowe hasło:<br>
            <input type=\"text\" name=\"new_pass\"><br><br>
            <input type=\"submit\" value=\"Zmień hasło\" style=\"font-size: 24px;\">
            </form>
            <br>
            <br>
            <a class=\"button\" href=\"sanepid_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>