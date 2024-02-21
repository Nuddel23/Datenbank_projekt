<html>
    <head>
        <title> Login Page </title>
    </head>
    <body>
        <h1>Login</h1>
        <a href="registrieren.php">Registrieren</a> </br>
        <p></p>
        <form method="post" action="">
            Benutzername: <input type="text" name="Benutzername"/></br>
            Passwort: <input type="password" name="Passwort"/></br>
            <input type="submit" name="submit" value="Login"/>
        </form>
        <?php
            if (isset($_POST["submit"])){
                $db = new mysqli('localhost', 'root', '', 'uni');    
                
                $query = "SELECT * FROM benutzer";
                $result = $db->execute_query($query);
                $name = $_POST["Benutzername"];

                foreach ($result as $row) {
                    if ($row["Benutzername"] == $name) {
                        if (hash_equals(hash_hmac('sha256', $_POST["Passwort"], $name), $row["Passwort"])) { //Passwort entschlüsseln
                            session_start();
                            $_SESSION["row"]=$row;
                            header("Location: page.php");
                            exit;
                        }
                    }
                } 
                echo nl2br ("Login fehlgeschlagen\rPasswort oder Benutzername ist falsch");
                exit;
            }
        ?>
    </body>
</html>