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
            echo "<h2>Zmień swoje dane kontaktowe</h2>";
            echo "
            <div id=\"formularz\">
                <form name=\"dane\" method=\"post\" action=\"osoba_contact.php\">
                    Wybierz typ danych, które chcesz zmienić, a następnie przypisz nową wartość w polu poniżej.<br><br>
                    <input type=\"radio\" id=\"telefon\" name=\"co\">
                    Zmień swój numer telefonu<br><br>
                    <input type=\"radio\" id=\"osoba\" name=\"co\">
                    Dodaj lub zmień osobę kontaktową*<br><br>
                    Nowe dane:
                    <input type=\"text\" name=\"nowa\"><br><br>
                    <input type=\"submit\" value=\"Dalej\" style=\"font-size: 24px;\">
                    <br><br><br>* - Osoba kontaktowa, to taka, która ma dostęp do wglądu podstawowych informacji o Tobie.
                </form>
            </div>
            <br>
            <br>
            <a class=\"button\" href=\"osoba_main.php\" title=\"Wróć do strony głównej\">Wróć do strony głównej</a>";
        }
        else{
            header("Location: ../index.html");
        }
        
        ?>
        
    </div>
</body>

</html>