<?php
class Register
{
    protected $user = array();
    private $host = "host = localhost";
    private $port = "port = 5432";
    private $dbname = "dbname = u8rogowski";
    private $credentials = "user = u8rogowski password=8rogowski";

    function __construct()
    {
        session_start();
    }

    function execute_sql($query)
    {
        $db = pg_connect( "$this->host $this->port $this->dbname $this->credentials" );
        if(!$db) 
        {
            echo "<script>alert('Nastąpił błąd podczas łączenia się z bazą.');</script>";
        }
        $answ = pg_query($db, $query);
        pg_close($db);
        return $answ;
    }

    /* Sprawdzamy czy uzytkownik jest zalogowany */
    function _is_logged_as($type)
    {
        if (isset($_SESSION['auth']) && isset($_SESSION[$type])) {
            $ret = $_SESSION['auth'] == 'OK' ? true : false;
        } else {
            $ret = false;
        }
        return $ret;
    }

    /* Logowanie uzytkownika do serwisu */
    function _login_as($type)
    {
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $access = false;
        $db = pg_connect( "$this->host $this->port $this->dbname $this->credentials" );
        if(!$db) 
        {
            echo "<script>alert('Nastąpił błąd podczas łączenia się z bazą.');</script>";
        }

        switch($type)
        {
            case 'osoba':
                $sql = "SELECT osoba_pesel, osoba_haslo FROM projekt.osoba WHERE osoba_pesel = '{$login}'";
                break;
            
            case 'lekarz':
                $sql = "SELECT lekarz_id, lekarz_haslo FROM projekt.lekarz WHERE lekarz_id = '{$login}'";
                break;

            case 'lab':
                $sql = "SELECT pracownik_laboratorium_id, pracownik_laboratorium_haslo FROM projekt.pracownik_laboratorium WHERE pracownik_laboratorium_id = '{$login}'";
                break;

            case 'sanepid':
                $sql = "SELECT sanepid_id, sanepid_haslo FROM projekt.sanepid WHERE sanepid_id = '{$login}'";
                break;
        }
        
        $answ = pg_query($db, $sql);
        
        if ($answ) 
        {
            $row = pg_fetch_row($answ);
            if($row && $row[1] == $pass)
            {
                $_SESSION['auth'] = 'OK';
                $_SESSION[$type] = $login;
                $access = true;
            }
        }
        else
        {
            echo pg_last_error($db);
            exit;
        }
        pg_close($db);
        if($access)
        {
            switch($type)
            {
                case 'osoba':
                    header("Location: osoba_main.php");
                    break;
                
                case 'lekarz':
                    header("Location: lekarz_main.php");
                    break;

                case 'lab':
                    header("Location: labprac_main.php");
                    break;

                case 'sanepid':
                    header("Location: sanepid_main.php");
                    break;
            }
        }
        else
        {
            echo "<script>alert('Zły login lub hasło. Spróbuj ponownie')</script>";
            switch($type)
            {
                case 'osoba':
                    echo "<a class=\"button\" href=\"osoba_log.html\">Powrót do strony z logowaniem</a>";
                    break;
                
                case 'lekarz':
                    echo "<a class=\"button\" href=\"lekarz_log.html\">Powrót do strony z logowaniem</a>";
                    break;

                case 'lab':
                    echo "<a class=\"button\" href=\"labprac_log.html\">Powrót do strony z logowaniem</a>";
                    break;

                case 'sanepid':
                    echo "<a class=\"button\" href=\"sanepid_log.html\">Powrót do strony z logowaniem</a>";
                    break;
            }
        }
    }
    
    /* Wylogowanie uzytkownika do serwisu */
    function _logout()
    {
        unset($_SESSION);
        session_destroy();
    }
}
?>
