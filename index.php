<html>

<head>
    <title> Login Page </title>
    <link rel="stylesheet" href="css/homepage.css?v=<?php echo time(); ?>">
</head>

<body class="header">
    <div class="login">
        <a href="homepage.php"><img src="../img/logo-2.png"></a>
        <h1>Login</h1>
        </br>
        <form method="post" action="">
            <input type="text" placeholder="Benutzername" name="Benutzername" /></br>
            <input type="password" placeholder="Passwort" name="Passwort" /></br></br>
            <input type="submit" class="submit" name="submit" value="Login" />
        </form>
        </br>
    </div>
    <?php
    session_start();
    if (isset($_SESSION["login"]) == false) {
        $_SESSION["login"] = false;
    }
    // if ($_SESSION['login'] == true){
    //     header("Location: homepage.php");
    // }
    
    if (isset($_POST["submit"])) {
        require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

        $query = "SELECT `benutzer`.*, `benutzer_id`.*
                            FROM `benutzer` 
                            LEFT JOIN `benutzer_id` ON `benutzer`.`ID` = `benutzer_id`.`Ben_ID`;";
        $result = $db->execute_query($query);
        $name = $_POST["Benutzername"];
        foreach ($result as $row) {
            if ($row["Benutzername"] == $name) {
                if (hash_equals(hash_hmac('sha256', $_POST["Passwort"], $name), $row["Passwort"])) { //Passwort entschlüsseln
                    $_SESSION['login'] = true;
                    $_SESSION["benutzer"] = $row;
                    $_SESSION["Roll_ID"] = $row["Roll_ID"];
                    header("Location: load.php");
                    exit;
                }
            }
        }
        echo nl2br("Login fehlgeschlagen\rPasswort oder Benutzername ist falsch");
        exit;
    }

    ?>

</body>

</html>