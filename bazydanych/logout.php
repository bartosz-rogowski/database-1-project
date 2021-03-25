<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="Author" content="Bartosz Rogowski" />
    <title>
        Wylogowano użytkownika
    </title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <div id="container">
        <?php
        include 'Register.php';
        $user = new Register;
        $user->_logout();
        echo "<h2>Użytkownik został wylogowany poprawnie!</h2>";
        echo "<a class=\"button\" href=\"index.html\">Powrót do strony głównej</a>";
        ?>
    </div>
</body>

</html>