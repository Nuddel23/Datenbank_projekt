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
            <select method="POST" name="Rolle" id="Rolle" size="1">
                <option value="1" name="Student"> Student </option>
                <option value="2" name="Dozent"> Dozent </option>
                <option value="3" name="Admin"> Admin </option>
            </select></br></br>
            <input type="submit" name="submit" value="Registrieren"/>
        </form>
        <?php
            $db = new mysqli('localhost', 'root', '', 'uni');    
            
            if (isset($_POST["submit"])){
                $name = $_POST["Benutzername"];
                $pass = hash_hmac('sha256', $_POST['Passwort'], $name); //Passwort verschlüsseln
                $rolle = $_POST["Rolle"];

                $query = "SELECT * FROM benutzer";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if ($row["Benutzername"] == $name) {
                        echo ("Benutzername exestiert bereits");
                        exit;
                    }
                }
                
                if ($_POST["Passwort"] == $_POST["Passwort2"]){
                    $query = sprintf ("INSERT INTO `benutzer` (id, Benutzername, Passwort, Roll_id) 
                                        VALUES ('NULL', '%s', '%s', '%s')", $name, $pass, $rolle);

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