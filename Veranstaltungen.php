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


        #daten Verarbeiten
        if (isset($_POST["bevorstehend"])) {
            $query = sprintf("INSERT INTO `student_konver` (`KonVer_ID`, `Matrikelnummer`, `Note`) VALUES ('%s', '%s', NULL) ", $_POST["KonVer_ID"], $_SESSION["benutzer"]["Matrikelnummer"]);

            if ($db->execute_query($query) === true) {
                echo ("Konkrete Veranstaltung eintragen success");

            } else {
                echo ($db->error);
            }

        }
        if (isset($_POST["geplant"])) {
            $query = sprintf("DELETE FROM student_konver WHERE `student_konver`.`KonVer_ID` = %s AND `student_konver`.`Matrikelnummer` = %s", $_POST["KonVer_ID"], $_SESSION["benutzer"]["Matrikelnummer"]);

            if ($db->execute_query($query) === true) {
                echo ("Konkrete Veranstaltung abmelden success");

            } else {
                echo ($db->error);
            }
        }




        #Daten abfragen
        $query = "SELECT `studiengang`.`Bezeichnung` AS `Bezeichnung_studi`, `beinhaltet`.`Semester`, `modul`.`Bezeichnung` AS `Bezeichnung_modul`, `veranstaltung`.*, `konkrete_veranstaltung`.`Datum`, `konkrete_veranstaltung`.`KonVer_ID`, `semester`.*, `dozent`.`Name`, `student_konver`.`Matrikelnummer`, `student_konver`.`Note`
        FROM `studiengang` 
            LEFT JOIN `beinhaltet` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID` 
            LEFT JOIN `modul` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `veranstaltung` ON `veranstaltung`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
            LEFT JOIN `semester` ON `beinhaltet`.`Semester` = `semester`.`Semi_ID` 
            LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID` 
            LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID`
            ORDER BY `studiengang`.`Bezeichnung` ASC,`konkrete_veranstaltung`.`Datum` DESC;";

        $result = $db->execute_query($query);


        # sotieren
        $uni = array();
        foreach ($result as $row) {
            if ($_SESSION["benutzer"]["Matrikelnummer"] == $row["Matrikelnummer"] && strtotime($row["Datum"]) < time()) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["teilgenommen"][$row["Bezeichnung"]] = $row;
            } elseif ($_SESSION["benutzer"]["Matrikelnummer"] == $row["Matrikelnummer"] && strtotime($row["Datum"]) > time()) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["geplant"][$row["Bezeichnung"]] = $row;
            } elseif ($row["Matrikelnummer"] == NULL && strtotime($row["Datum"]) > time()) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["bevorstehend"][$row["Bezeichnung"]] = $row;
            } elseif ($row["KonVer_ID"] == NULL) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["ungeplant"][$row["Bezeichnung"]] = $row;
            }
        }
        #print_r($uni);
        
        #anzeigen
        foreach ($uni as $s_key => $studiengang) {
            printf("<details open><summary><b>Studiengang: %s</b> </summary><ul>", $s_key);
            foreach ($studiengang as $m_key => $modul) {
                printf("<li><details open><summary>Modul: %s </summary><ul>", $m_key);
                foreach ($modul as $v_key => $Veranstaltung) {
                    printf("<li><details open><summary>Veranstalltung: %s </summary><ul>", $v_key);
                    foreach ($Veranstaltung as $row) {
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
                        if ($key == "Note" && $val != "") {
                            echo ("Note: " . $val . "</br>");
                        }
                        if ($v_key == "bevorstehend") {
                            printf('
                                <form method="POST" action="">
                                <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
                                <input type="submit" name="%s" value="eintragen"/>
                                </form>',
                                $row["KonVer_ID"],
                                $v_key
                            );
                        }
                        if ($v_key == "geplant"){
                            printf('
                                <form method="POST" action="">
                                <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
                                <input type="submit" name="%s" value="abmelden"/>
                                </form>',
                                $row["KonVer_ID"],
                                $v_key
                            );
                        }
                        echo ("</fieldset></div></div>");
                    }
                    echo ("</ul></details></li>");
                }
                echo ("</ul></details></li>");
            }
            echo ("</ul></details>");
        }

        ?>
</body>

</html>