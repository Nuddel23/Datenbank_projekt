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
        // $query = "SELECT `student`.`Name`, `student_konver`.*, `konkrete_veranstaltung`.*, `veranstaltung`.`Bezeichnung` AS `Bezeichnung_ver`, `modul`.`Bezeichnung` AS `Bezeichnung_modul`, `studiengang`.`Bezeichnung` AS `Bezeichnung_studi`
        // FROM `student` 
        //     LEFT JOIN `student_konver` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer` 
        //     LEFT JOIN `konkrete_veranstaltung` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
        //     LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
        //     LEFT JOIN `modul` ON `veranstaltung`.`Modul_ID` = `modul`.`Modul_ID` 
        //     LEFT JOIN `studiengang` ON `student`.`Studi_ID` = `studiengang`.`Studi_ID`;";

        $query = "SELECT `konkrete_veranstaltung`.*, `veranstaltung`.`Bezeichnung`, `student_konver`.*, `student`.`Name`
        FROM `konkrete_veranstaltung` 
            LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
            LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
            LEFT JOIN `student` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer`;";

        $result = $db->execute_query($query);


        # sotieren
        $uni = array();

        foreach ($result as $row) {
            echo ('<div class="event start-2 end-5 securities"><div class="title"><fieldset>');
            foreach ($row as $key => $val) {
                // echo "$key: $val <br/>";
                switch ($key) {
                    case "Bezeichnung":
                        echo ("<legend>" . $val . "</legend>");
                        break;
                    case "Datum":
                        echo ("Datum: " . $val . "</br>");
                        break;
                    case "Name":
                        echo ("Student: " . $val . "</br>");
                        break;
                }
            }
            echo ("</fieldset></div></div>");
                    
            // if ($key == "Note" && $val != "") {
            //     echo ("Note: " . $val . "</br>");
            // }
            // if ($v_key == "bevorstehend") {
            //     printf('
            //         <form method="POST" action="">
            //         <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
            //         <input type="submit" name="%s" value="eintragen"/>
            //         </form>',
            //         $row["KonVer_ID"],
            //         $v_key
            //     );
            // }
            // if ($v_key == "geplant") {
            //     printf('
            //         <form method="POST" action="">
            //         <input type="hidden" id="KonVer_ID" name="KonVer_ID" value="%s">
            //         <input type="submit" name="%s" value="abmelden"/>
            //         </form>',
            //         $row["KonVer_ID"],
            //         $v_key
            //     );
            // }
        }/*




            if ($_SESSION["benutzer"]["Dozi_ID"] == $row["Dozi_ID"]) {
                $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung_ver"]][] = $row;

                // if ($_SESSION["benutzer"]["Matrikelnummer"] == $row["Matrikelnummer"] && strtotime($row["Datum"]) < time()) {
                //     $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["teilgenommen"][$row["Bezeichnung"]] = $row;
                // } elseif ($_SESSION["benutzer"]["Matrikelnummer"] == $row["Matrikelnummer"] && strtotime($row["Datum"]) > time()) {
                //     $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["geplant"][$row["Bezeichnung"]] = $row;
                // } elseif ($row["Matrikelnummer"] == NULL && strtotime($row["Datum"]) > time()) {
                //     $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["bevorstehend"][$row["Bezeichnung"]] = $row;
                // } elseif ($row["KonVer_ID"] == NULL) {
                //     $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]]["ungeplant"][$row["Bezeichnung"]] = $row;
                // }
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
                                case "Bezeichnung_ver":
                                    echo ("<legend>" . $val . "</legend>");
                                    break;
                                case "Datum":
                                    echo ("Datum: " . $val . "</br>");
                                    break;
                                case "Name":
                                    echo ("Student: " . $val . "</br>");
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
                        if ($v_key == "geplant") {
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
        }*/

        ?>
</body>

</html>