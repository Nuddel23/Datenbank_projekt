<html>
    <head>
        <title> User_auflisten </title>
    </head>
    <body>
        <?php
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $db = new mysqli('localhost', 'root', '', 'login');

            $query = "SELECT * FROM accounts";
            $result = $db->execute_query($query);
            foreach ($result as $row) {
                echo nl2br ("Name: ".$row["Benutzername"]." Passwort: ".$row["Passwort"]."\n");
            }
        ?>
    </body>
</html>