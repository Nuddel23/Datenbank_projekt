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
        $uni = array();
        $query = "SELECT `studiengang`.`Bezeichnung` AS `Bezeichnung_studi`, `beinhaltet`.`Studi_ID`, `modul`.`Bezeichnung` AS `Bezeichnung_modul`, `veranstaltung`.*, `konkrete_veranstaltung`.*
        FROM `studiengang` 
            LEFT JOIN `beinhaltet` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID` 
            LEFT JOIN `modul` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `veranstaltung` ON `veranstaltung`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID`;";

        $struktur = $db->execute_query($query);

        $query = sprintf("SELECT `konkrete_veranstaltung`.*, `student_konver`.`Matrikelnummer`, `student_konver`.`Note`, `student`.`Studi_ID`
        FROM `konkrete_veranstaltung` 
            LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
            LEFT JOIN `student` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer`
            GROUP BY `konkrete_veranstaltung`.`KonVer_ID`;");

        $daten = $db->execute_query($query);


        #sotieren
        foreach ($struktur as $row) {
            if ($row["Studi_ID"] == $_SESSION["benutzer"]["Studi_ID"]) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]] = $row;
                if ($uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]]["KonVer_ID"] == NULL) {
                    $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]]["typ"] = "ungeplant";
                } else {
                    foreach ($daten as $date) {
                        if ($row["KonVer_ID"] == $date["KonVer_ID"]) {
                            if ($date["Matrikelnummer"] != NULL && $date["Matrikelnummer"] != $_SESSION["benutzer"]["Matrikelnummer"]) {
                                $date["Matrikelnummer"] = NULL;
                            }
                            if ($date["Matrikelnummer"] == NULL) {
                                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]]["typ"] = "bevorstehend";
                            } 
                            else if ($date["Matrikelnummer"] == $_SESSION["benutzer"]["Matrikelnummer"]) {
                                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]] = $row + $date;
                                if ( strtotime($row["Datum"]) < time()){
                                    $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]]["typ"] = "teilgenommen";
                                }else{
                                    $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]]["typ"] = "geplant";
                                }
                            }
                        }
                    }
                }
            }
        }

        // print_r($uni);
        // print_r($_SESSION);


        #anzeigen
        foreach ($uni as $s_key => $studiengang) {
            printf("<details open><summary><b>Studiengang: %s</b> </summary><ul>", $s_key);
            foreach ($studiengang as $m_key => $modul) {
                printf("<li><details open><summary>Modul: %s </summary><ul>", $m_key);
                foreach ($modul as $v_key => $Veranstaltung) {
                    printf("<li><details open><summary>Veranstalltung: %s </summary><ul>", $v_key);

                    echo ('<div class="event start-2 end-5 securities"><div class="title"><fieldset>');
                    foreach ($Veranstaltung as $key => $val) {
                        // echo "$key: $val <br/>";
                        switch ($key) {
                            case "Bezeichnung_ver":
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
                            case "typ":
                                echo ("Status: " . $val . "</br>");
                                if ($val == "bevorstehend") {
                                    printf('
                                            <form method="POST" action="">
                                            <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
                                            <input type="submit" name="%s" value="eintragen"/>
                                            </form>',
                                        $Veranstaltung["KonVer_ID"],
                                        $val
                                    );
                                }
                                else if ($val == "geplant") {
                                    printf('
                                            <form method="POST" action="">
                                            <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
                                            <input type="submit" name="%s" value="abmelden"/>
                                            </form>',
                                        $Veranstaltung["KonVer_ID"],
                                        $val
                                    );
                                }
                                break;
                            }
                            if ($key == "Note" && $val != "") {
                                echo ("Note: " . $val . "</br>");
                            }
                    }

                    echo ("</fieldset></div></div>");

                    echo ("</ul></details></li>");
                }
                echo ("</ul></details></li>");
            }
            echo ("</ul></details>");
        }

        ?>
</body>

</html>