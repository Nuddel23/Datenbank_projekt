<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studiengang hinzufügen</title>
</head>

<body>
    <?php
    #Setup
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

    $AdminOnly = true;
    require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";
    ?>
    <form method="post" action="">
        <input type="submit" name="Abmelden" value="Abmelden" />
        </from>

        <a href="/../homepage.php">Homepage</a></br>
        <h1>Studiengang hinzufügen:</h1>

        <form method="post" action="">
            Bezeichnung: <input type="text" name="Bezeichnung" required /></br>
            <input type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
        if (isset($_POST["submit"])) {
            $query = "SELECT * FROM studiengang";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if ($row["Bezeichnung"] == $_POST["Bezeichnung"]) {
                    echo ("Studiengang exestiert bereits");
                    exit;
                }
            }

            $query = sprintf("INSERT INTO `studiengang` (`Studi_ID`, `Bezeichnung`) 
                VALUES (Null, '%s') ", $_POST["Bezeichnung"]);

            if ($db->execute_query($query) === true) {
                echo ("success");
                $_POST = array();
            } else {
                echo ($db->error);
            }
        }
        ?>
</body>

</html>