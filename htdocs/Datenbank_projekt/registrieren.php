<html>
    <head>
        <title>Registrieren</title>
    </head>
    <body>
        <h1>Registrieren</h1>
        <a href="index.php">Login</a> </br>
        <p></p>
        <form method="post" action="">
            Benutzername: <input type="text" name="Benutzername"/></br>
            Passwort: <input type="password" name="Passwort"/></br>
            Passwort bestätigen: <input type="password" name="Passwort2"/></br>
            <input type="submit" name="submit" value="Login"/>
        </form>
        <?php
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $db = new mysqli('localhost', 'root', '', 'login');    
            
            if (isset($_POST["submit"])){
                $name = $_POST["Benutzername"];
                $pass = hash_hmac('sha256', $_POST['Passwort'], $name); //Passwort verschlüsseln

                $query = "SELECT * FROM accounts";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if ($row["Benutzername"] == $name) {
                        echo ("Benutzername exestiert bereits");
                        exit;
                    }
                }


                if ($_POST["Passwort"] == $_POST["Passwort2"]){
                    $query = sprintf ("INSERT INTO `accounts` (Benutzer_ID, Benutzername, Passwort) 
                                        VALUES ('NULL', '%s', '%s')", $name, $pass);

                    if ($db->execute_query($query) === true) {
                        echo ("success");
                        $_POST = array();
                    }
                    else {
                        echo (mysqli::error);
                    }
                }
                else {
                    echo ("Die beiden Passwort Felder Stimmen nicht überein");
                }
            }

        ?>
    </body>
</html>