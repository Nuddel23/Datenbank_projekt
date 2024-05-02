<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul hinzufügen</title>
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
        <h1>Modul hinzufügen:</h1>
        <form method="post" action="">
            <?php
            #Studiengang auswahl
            $query = "SELECT * FROM `studiengang`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                echo sprintf('<input type="checkbox" id="%s" name="studiengang[]" value="%s">
                        <label for="%s">%s</label></br>', $row["Bezeichnung"], $row["Studi_ID"], $row["Bezeichnung"], $row["Bezeichnung"]);
            }

            #Semester auswahl
            echo ("Semester: ");
            echo ('<select name="Semester">');

            $query = "SELECT * FROM `semester`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if (isset($_POST["Semi_ID"]) == false) {
                    $_POST["Semi_ID"] = $row["Semi_ID"];
                }


                if ($row["Semi_ID"] == $_POST["Semi_ID"]) {
                    echo ('<option selected="selected" value="' . $row["Semi_ID"] . '">
                ' . $row["Semester"] . " " . $row["Jahr"] . '</option>');
                } else {
                    echo ('<option value="' . $row["Semi_ID"] . '">
                ' . $row["Semester"] . " " . $row["Jahr"] . '</option>');
                }
            }
            echo ("</select></br>");
            ?>
            Modulname: <input type="text" name="Modul_name" required /></br>
            <input type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
        if (isset($_POST["submit"])) {

            #Prüfen ob es das Modul schon gibt
            $query =
                "SELECT `modul`.`Bezeichnung`, `beinhaltet`.*
                    FROM `modul` 
                        LEFT JOIN `beinhaltet` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID`;";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                foreach ($_POST["studiengang"] as $studiengang) {
                    if ($row["Bezeichnung"] == $_POST["Modul_name"] && $row["Studi_ID"] == $studiengang) {
                        echo ("Modul exestiert bereits </br>");
                        exit;
                    }
                }
            }

            #Addresse einfügen
            $query = sprintf("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni' AND TABLE_NAME = 'modul'; ");
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                $Modul_ID = $row["AUTO_INCREMENT"];
            }

            $query = sprintf("INSERT INTO `modul` (`Modul_ID`, `Bezeichnung`) VALUES ('%s', '%s')", $Modul_ID, $_POST["Modul_name"]);

            if ($db->execute_query($query) === true) {
                echo ("Modul success </br>");
            } else {
                echo ($db->error);
            }

            #beinhaltet einfügen
            foreach ($_POST["studiengang"] as $studiengang) {
                $query = sprintf("INSERT INTO `beinhaltet` (`Studi_ID`, `Modul_ID`, `Semester`) VALUES ('%s', '%s', '%s') ", $studiengang, $Modul_ID, $_POST["Semi_ID"]);

                if ($db->execute_query($query) === true) {
                    echo ("beinhaltet success </br>");
                } else {
                    echo ($db->error);
                }
            }

        }
        ?>
</body>

</html>