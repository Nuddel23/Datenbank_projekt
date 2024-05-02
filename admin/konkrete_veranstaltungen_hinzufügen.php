<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <h1>Konkrete Veranstaltung erstellem:</h1>
        <?php

        $query = "SELECT `veranstaltung`.*, `modul`.`Bezeichnung` AS `Bezeichnung_modul`, `veranstaltungsart`.`Bezeichnung` AS `Bezeichnung_art`, `konkrete_veranstaltung`.`KonVer_ID`
            FROM `veranstaltung` 
            LEFT JOIN `modul` ON `veranstaltung`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `veranstaltungsart` ON `veranstaltung`.`Art_ID` = `veranstaltungsart`.`Art_ID` 
            LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID`
            WHERE `konkrete_veranstaltung`.`KonVer_ID` IS NULL;";

        $result = $db->execute_query($query);

        echo ('<form method="POST" action="">');

        # Veranstaltung auswahl
        echo ('<select name="Veranstaltungs_ID" onchange="this.form.submit()">');
        foreach ($result as $row) {

            # falls NULL populiere
            if (isset($_POST["Veranstaltungs_ID"]) == false) {
                $_POST["Veranstaltungs_ID"] = $row["Veranstaltungs_ID"];
            }

            if ($row["Veranstaltungs_ID"] == $_POST["Veranstaltungs_ID"]) {
                echo ('<option selected="selected" value="' . $row["Veranstaltungs_ID"] . '">
                ' . $row["Bezeichnung"] . '</option>');
            } else {
                echo ('<option value="' . $row["Veranstaltungs_ID"] . '">
                ' . $row["Bezeichnung"] . '</option>');
            }

        }
        echo ("</select></br>");

        #Veranstaltung Beschtreibung
        foreach ($result as $row) {
            if ($row["Veranstaltungs_ID"] == $_POST["Veranstaltungs_ID"]) {
                echo ("Modul: " . $row["Bezeichnung_modul"] . "</br>");
                echo ("Veranstaltungsart: " . $row["Bezeichnung_art"] . "</br>");
                echo ("CP: " . $row["CP"] . "</br>");

                #eingabe
                echo ('Datum: <input type="date" name="Datum" required /></br>');

                #dozent
                echo ('Dozent: <select name="Dozi_ID">');
                $query = "SELECT * FROM `dozent`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<option value="' . $row["Dozi_ID"] . '" required>
                    ' . $row["Name"] . '</option>');
                }
                echo ("</select></br>");

                #Semester
                echo ('Semester: <select name="Semi_ID">');
                $query = "SELECT * FROM `semester`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<option value="' . $row["Semi_ID"] . '">
                ' . $row["Semester"] . " " . $row["Jahr"] . '</option>');
                }
                echo ("</select></br>");

                echo ('<input type="submit" name="submit" value="erstellen" />');
            }
        }

        echo ('</form>');

        if (isset($_POST["submit"])) {
            $query = sprintf(
                "INSERT INTO `konkrete_veranstaltung` (`KonVer_ID`, `Datum`, `Veranstaltungs_ID`, `Semi_ID`, `Dozi_ID`) VALUES (NULL, '%s', '%s', '%s', '%s') ",
                $_POST["Datum"],
                $_POST["Veranstaltungs_ID"],
                $_POST["Semi_ID"],
                $_POST["Dozi_ID"]
            );

            if ($db->execute_query($query) === true) {
                echo ("Konkrete Veranstaltung success</br>");
            } else {
                echo ($db->error);
            }
        }
        ?>
</body>

</html>