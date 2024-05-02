<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homepage.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <form method="post" action="">
        <input type="submit" name="Abmelden" value="Abmelden" />
        </from>
        <a href="homepage.php">Homepage</a>

        <?php
        #Setup
        session_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

        $AdminOnly = false;
        require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";

        echo ('<div class="calender">');

        if ($_SESSION["Roll_ID"] == 3) {
            exit;
        }

        echo ("<details><summary>Test</summary><p>");
        #daten Verarbeiten
        if (isset($_POST["geplant"])) {
            $query = sprintf("INSERT INTO `student_konver` (`KonVer_ID`, `Matrikelnummer`, `Note`) VALUES ('%s', '%s', NULL) ", $_POST["KonVer_ID"], $_SESSION["benutzer"]["Matrikelnummer"]);

            if ($db->execute_query($query) === true) {
                echo ("Konkrete Veranstaltung success");
            } else {
                echo ($db->error);
            }

        }

        #Daten abfragen
        $query =
            "SELECT `veranstaltung`.*, `konkrete_veranstaltung`.`Datum`, `konkrete_veranstaltung`.`KonVer_ID`, `semester`.*, `dozent`.`Name`, `student_konver`.`Matrikelnummer`, `student_konver`.`Note`
            FROM `veranstaltung` 
                LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                LEFT JOIN `semester` ON `konkrete_veranstaltung`.`Semi_ID` = `semester`.`Semi_ID` 
                LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID` 
                LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID`;";

        $result = $db->execute_query($query);

        # sotieren
        $Veranstaltungen = array(
            "teilgenommen" => array(),
            "geplant" => array(),
            "ungeplant" => array()
        );

        foreach ($result as $row) {
            if ($_SESSION["benutzer"]["Matrikelnummer"] == $row["Matrikelnummer"]) {
                $Veranstaltungen["teilgenommen"][] = $row;
            } elseif ($row["Matrikelnummer"] == NULL && strtotime($row["Datum"]) > time()) {
                $Veranstaltungen["geplant"][] = $row;
            } elseif ($row["KonVer_ID"] == NULL) {
                $Veranstaltungen["ungeplant"][] = $row;
            }
        }

        # anzeigen
        foreach ($Veranstaltungen as $t_key => $tabelle) {
            echo ('<div class="day"><div class="event">');
            foreach ($tabelle as $row) {
                echo ('<div class="event start-2 end-5 securities"><div class="title"><fieldset>');
                foreach ($row as $key => $val) {
                    // echo "$key: $val <br/>";
                    switch ($key) {
                        case "Bezeichnung":
                            echo ("<legend>" . $val . "</legend>");
                            break;
                        case "CP":
                            echo ("CP: " . $val . "</br>");
                            break;
                        case "Datum":
                            echo ("Datum: " . $val . "</br>");
                            break;
                        case "Semester":
                            echo ("Semester: " . $val);
                            break;
                        case "Jahr":
                            echo (" " . $val . "</br>");
                            break;
                        case "Name":
                            echo ("Dozent: " . $val . "</br>");
                            break;
                    }
                }
                if ($t_key == "geplant") {
                    printf('
                    <form method="POST" action="">
                    <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
                    <input type="submit" name="%s" value="eintragen"/>
                    </form>',
                        $row["KonVer_ID"],
                        $t_key
                    );

                }
                echo ("</fieldset></div></div>");
            }
            echo ('</div></div>');
            echo ("ende von ");
            #print_r($tabelle);
        }
        echo ("</p></details>");
        ?>
        </div>
</body>

</html>