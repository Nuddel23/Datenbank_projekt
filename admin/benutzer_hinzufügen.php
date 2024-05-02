<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer erstellen</title>
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
        <h1>Benutzer erstellen:</h1>

        <?php

        #Rolle auswahl
        echo ('
                <form method="POST" action="">
                Rolle: <select name="rolle" onchange="this.form.submit()">');

        $query = "SELECT * FROM `rollen`";
        $result = $db->execute_query($query);

        if (isset($_POST["rolle"]) == false) {
            $_POST["rolle"] = 1;
        }

        foreach ($result as $row) {
            if ($row["Roll_ID"] == $_POST["rolle"]) {
                echo ('<option selected="selected" value="' . $row["Roll_ID"] . '">
                ' . $row["Rolle"] . '</option>');
            } else {
                echo ('<option value="' . $row["Roll_ID"] . '">
                ' . $row["Rolle"] . '</option>');
            }
        }

        echo ("</select></br></form>");



        #Daten eintragen
        echo ('<form method="POST" action="">');

        if ($_POST["rolle"] != 3) {
            echo (' Name: <input type="text" name="name" required /></br>
                    Vorname: <input type="text" name="vorname" required /></br>
                    Geburtsdatum: <input type="date" name="geburtstag" required /></br>
                    <input type="radio" id="mänlich" name="geschlecht" value="mänlich" required >
                    <label for="mänlich">Mänlich</label>
                    <input type="radio" id="weiblich" name="geschlecht" value="weiblich" required >
                    <label for="weiblich">Weiblich</label><br>
                    Konfession: <input type="text" name="konfession" required /></br>
                    Staatsangehörigkeit: <input type="text" name="staatsangehörigkeit" required /></br>
                    Adresse:</br>
                    Straße: <input type="text" name="Straße" required /></br>
                    Hausnummer: <input type="text" name="Hausnummer" required /></br>
                    PLZ: <input type="text" name="PLZ" required /></br>
                    Ort: <input type="text" name="Ort" required /></br>
                ');

            #Studiengang
            if ($_POST["rolle"] == 1) {
                echo ("Studiengänge:</br>");
                echo ('<select name="studiengang">');
                $query = "SELECT * FROM `studiengang`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<option value="' . $row["Studi_ID"] . '">
                        ' . $row["Bezeichnung"] . '</option>');
                }
                echo ("</select></br>");
            }
        }
        printf('<input type="hidden" id="rolle" name="rolle" value="%s">', $_POST["rolle"]);
        echo ('
            <input type="submit" name="submit1" value="einfügen" />
            </form>');



        #Daten verarbeiten
        if (isset($_POST["submit1"])) {

            if ($_POST["rolle"] != 3) {

                #Adresse
                $query =
                    "SELECT `adresse`.`Adress_ID`, `adresse`.`Straße`, `adresse`.`Hausnummer`, `plz`.*
                    FROM `adresse` 
                        LEFT JOIN `plz` ON `adresse`.`PLZ` = `plz`.`PLZ`;";
                $result = $db->execute_query($query);
                $new_adresse = true;
                $new_PLZ = true;


                foreach ($result as $row) {
                    if ($row["PLZ"] == $_POST["PLZ"] && $row["Ort"] == $_POST["Ort"]) {
                        $new_PLZ = false;
                    }
                    if ($row["Straße"] == $_POST["Straße"] && $row["Hausnummer"] == $_POST["Hausnummer"] && $row["PLZ"] == $_POST["PLZ"] && $row["Ort"] == $_POST["Ort"]) {
                        $new_adresse = false;
                        $adresse = $row["Adress_ID"];
                    }

                }

                #Neuer Ort falls keiner vorhanden
                if ($new_PLZ) {
                    $query = sprintf("INSERT INTO `plz` (`PLZ`, `Ort`) VALUES ('%s', '%s') ", $_POST["PLZ"], $_POST["Ort"]);

                    if ($db->execute_query($query) === true) {
                        echo ("PLZ success </br>");
                    } else {
                        echo ($db->error);
                    }
                }

                #adresse hinzufügen
                if ($new_adresse) {
                    $query = sprintf("INSERT INTO `adresse` (`Adress_ID`, `Straße`, `Hausnummer`, `PLZ`) 
                                        VALUES (NULL, '%s', '%s', '%s') ", $_POST["Straße"], $_POST["Hausnummer"], $_POST["PLZ"]);

                    if ($db->execute_query($query) === true) {
                        echo ("Adrese success </br>");
                        $adresse = $db->insert_id;
                    } else {
                        echo ($db->error);
                    }
                }

                #query auswahl
                if ($_POST["rolle"] == 1) {

                    #student insert
                    $query = sprintf("INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`, `Studi_ID`) 
                    VALUES ('NULL', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ",
                        $_POST["name"],
                        $_POST["vorname"],
                        $_POST["geburtstag"],
                        $_POST["geschlecht"],
                        $_POST["konfession"],
                        $_POST["staatsangehörigkeit"],
                        $adresse,
                        $_POST["studiengang"]
                    );
                } elseif ($_POST["rolle"] == 2) {

                    #dozent insert
                    $query = sprintf("INSERT INTO `dozent` (`Dozi_ID`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`) 
                    VALUES ('NULL', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ",
                        $_POST["name"],
                        $_POST["vorname"],
                        $_POST["geburtstag"],
                        $_POST["geschlecht"],
                        $_POST["konfession"],
                        $_POST["staatsangehörigkeit"],
                        $adresse
                    );
                }

                #einfügen
                if ($db->execute_query($query) === true) {
                    echo ('rolle success</br>');
                } else {
                    echo ($db->error);
                }
            }

            #benutzer_ID einfügen
            $Person_ID = $db->insert_id;

            switch ($_POST["rolle"]) {
                case 1:
                    $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES ('NULL', '%s', '%s', NULL)", $_POST["rolle"], $Person_ID);
                    break;
                case 2:
                    $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES ('NULL', '%s', NULL, '%s')", $_POST["rolle"], $Person_ID);
                    break;
                case 3:
                    $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES ('NULL', '%s', NULL, Null)", $_POST["rolle"]);
                    break;
            }

            if ($db->execute_query($query) === true) {
                echo ("benutzer success</br>");
                $random = rand();
                $Ben_ID = $db->insert_id;
                echo ("<a href='http://localhost/registrieren.php?ID=" . hash_hmac('sha256', $Ben_ID, $random) . "'>Registrieren</a></br>");
                echo ("Admin Code: " . $random);
            } else {
                echo ($db->error);
            }
        }
        ?>
</body>

</html>