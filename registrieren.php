<html>

<head>
    <title>Registrieren</title>
    <link rel="stylesheet" href="css/homepage.css?v=<?php echo time(); ?>">
</head>

<body class="header">
    <div class="login">
        <h1>Registrieren</h1>
        <form method="post" action="">
            <input type="text" placeholder="Admin code" name="Admin_code" required /></br>
            <input type="text" placeholder="Benutzername" name="Benutzername" required /></br>
            <input type="password" placeholder="Passwort" name="Passwort" required /></br>
            <input type="password" placeholder="Passwort bestätigen" name="Passwort2" required /></br></br>
            <input type="submit" class="submit" name="submit" value="Registrieren" required />
        </form>

        <?php
        require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

        if (isset($_POST["submit"])) {

            $name = $_POST["Benutzername"];
            $pass = hash_hmac('sha256', $_POST['Passwort'], $name); //Passwort verschlüsseln
        
            if (isset($_GET["ID"]) == false) {
                echo ("Bitte benutze einen link der dir von einem Admin gegeben wurde");
                exit;
            }

            $query = "SELECT * FROM benutzer_ID";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if (hash_equals(hash_hmac('sha256', $row["Ben_ID"], $_POST["Admin_code"]), $_GET["ID"])) {
                    $ID = $row["Ben_ID"];
                }
            }

            if (isset($ID) == false) {
                echo ("fehler");
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

            if ($_POST["Passwort"] == $_POST["Passwort2"]) {
                $query = sprintf("INSERT INTO `benutzer` (ID, Benutzername, Passwort) 
                                        VALUES ('%s', '%s', '%s')", $ID, $name, $pass);

                if ($db->execute_query($query) === true) {
                    echo ('<a href="index.php" class="submit">Login</a></br>');
                    $_POST = array();
                } else {
                    echo ($db->error);
                }
            } else {
                echo ("Die beiden Passwort Felder Stimmen nicht überein");
            }
        }

        ?>
    </div>
</body>

</html>