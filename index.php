<html>
    <head>
        <title> Login Page </title>
        <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h1>Login</h1>
        <p></p>
        <form method="post" action="">
            Benutzername: <input type="text" name="Benutzername"/></br>
            Passwort: <input type="password" name="Passwort"/></br>
            <input type="submit" name="submit" value="Login"/>
        </form>
        <?php
            session_start();
            if (isset($_SESSION["login"]) == false){
                $_SESSION["login"] = false;
            }
            // if ($_SESSION['login'] == true){
            //     header("Location: homepage.php");
            // }

            if (isset($_POST["submit"])){
                require $_SERVER['DOCUMENT_ROOT']."Datenbank";   
                
                $query = "SELECT `benutzer`.*, `benutzer_id`.*
                            FROM `benutzer` 
                            LEFT JOIN `benutzer_id` ON `benutzer`.`ID` = `benutzer_id`.`Ben_ID`;";
                $result = $db->execute_query($query);
                $name = $_POST["Benutzername"];

                foreach ($result as $row) {
                    if ($row["Benutzername"] == $name) {
                        if (hash_equals(hash_hmac('sha256', $_POST["Passwort"], $name), $row["Passwort"])) { //Passwort entschlüsseln
                            $_SESSION['login']=true;
                            $_SESSION["benutzer"]=$row;
                            $_SESSION["Roll_ID"]=$row["Roll_ID"];
                            header("Location: homepage.php");
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
