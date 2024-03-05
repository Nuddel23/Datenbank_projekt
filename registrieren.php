<html>
    <head>
        <title>Registrieren</title>
    </head>
    <body>
        <h1>Registrieren</h1>
        <a href="index.php">Login</a> </br>
        <p></p>
        <form method="post" action="">
            Admin code: <input type="text" name="Admin_code" required /></br>
            Benutzername: <input type="text" name="Benutzername" required /></br>
            Passwort: <input type="password" name="Passwort" required /></br>
            Passwort bestätigen: <input type="password" name="Passwort2" required /></br>
            <input type="submit" name="submit" value="Registrieren" required />
        </form>
        <?php
            $db = new mysqli('localhost', 'root', '', 'uni');    
            
            if (isset($_POST["submit"])){
                $name = $_POST["Benutzername"];
                $pass = hash_hmac('sha256', $_POST['Passwort'], $name); //Passwort verschlüsseln

                if (isset($_GET["ID"]) == false){
                    echo("Bitte benutze einen link der dir von einem Admin gegeben wurde");
                    exit;
                }

                $query = "SELECT * FROM benutzer_ID";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if (hash_equals(hash_hmac('sha256', $row["Ben_ID"], $_POST["Admin_code"]), $_GET["ID"])) {
                        $ID = $row["Ben_ID"];
                    }
                }
                
                if(isset($ID) == false){
                    echo("fehler");
                    exit;
                }

                $query = "SELECT * FROM benutzer";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if ($row["Benutzername"] == $name) {
                        echo ("Benutzername exestiert bereits");
                        exit;
                    }
                }

                if ($_POST["Passwort"] == $_POST["Passwort2"]){
                    $query = sprintf ("INSERT INTO `benutzer` (ID, Benutzername, Passwort) 
                                        VALUES ('%s', '%s', '%s')", $ID, $name, $pass); //überarberiten

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