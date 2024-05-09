<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homepage.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <?php
    #Setup
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

    $AdminOnly = false;
    require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";
    ?>
    <section class="header">
        <nav>
            <a href="homepage.php"><img src="../img/logo-2.png"></a>
            <div class="nav-links">
                <ul>
                    <?php
                    #auf Rolle basierte Seiten
                    switch ($_SESSION["Roll_ID"]) {
                        case 1: //student
                            $query = "SELECT `student`.`Matrikelnummer`, `student_konver`.`Note`, `konkrete_veranstaltung`.`KonVer_ID`, `veranstaltung`.`CP`
                                            FROM `student` 
                                            LEFT JOIN `student_konver` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer` 
                                            LEFT JOIN `konkrete_veranstaltung` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
                                            LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID`;";

                            $stu = $db->execute_query($query);

                            echo ('<li><a href="Veranstaltungen.php">Veranstaltungen </a></li> ');
                            echo ('<li><a href="quicklinks.php">Quicklinks</a></li> ');

                            $CP = 0;
                            foreach ($stu as $row) {
                                if ($row["Matrikelnummer"] == $_SESSION["benutzer"]['Matrikelnummer']) {
                                    $CP += $row["CP"];
                                }
                            }
                            echo ("<li><p> CP: " . $CP . "</p></li>");

                            break;
                        case 2: //dozent
                            echo ('<li><a href="dozent_veranstaltung.php">Veranstalltungen </a></li> ');
                            break;
                        case 3: //admin
                            echo ('<li><a href="admin/benutzer_hinzufügen.php">Benuter erstellen </a></li>');
                            echo ('<li><a href="admin/studiengang_hinzufügen.php">Studiengang hinzufügen </a></li>');
                            echo ('<li><a href="admin/modul_hinzufügen.php">Modul hinzufügen </a></li>');
                            echo ('<li><a href="admin/veranstaltungen_hinzufügen.php">Veranstaltung hinzufügen </a></li>');
                            echo ('<li><a href="admin/konkrete_veranstaltungen_hinzufügen.php">konkret Veranstaltung hinzufügen </a></li>');
                            break;
                    }
                    ?>
                    <li><a href="homepage.php">HOME</a></li>
                    <li>
                        <form method="post" action="">
                            <input class="submitlink" type="submit" name="Abmelden" value="Abmelden" />
                        </form>
                    </li>
                </ul>
        </nav>
    </section>
    <div class="textbox">
        <?php


        #Daten abfragen       
        $uni = array();
        $query = "SELECT `studiengang`.`Bezeichnung` AS `Bezeichnung_studi`, `beinhaltet`.`Studi_ID`, `modul`.`Bezeichnung` AS `Bezeichnung_modul`, `veranstaltungsart`.`Bezeichnung` AS `Bezeichnung_art`, `dozent`.`Name`, `konkrete_veranstaltung`.*, `veranstaltung`.*
        FROM `studiengang` 
            LEFT JOIN `beinhaltet` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID` 
            LEFT JOIN `modul` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `veranstaltung` ON `veranstaltung`.`Modul_ID` = `modul`.`Modul_ID` 
            LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID`
            LEFT JOIN `veranstaltungsart` ON `veranstaltungsart`.`Art_ID` = `veranstaltung`.`Art_ID`
            LEFT JOIN `dozent` ON `dozent`.`Dozi_ID` = `konkrete_veranstaltung`.`Dozi_ID`;";

        $struktur = $db->execute_query($query);


        #sotieren
        foreach ($struktur as $row) {
            $uni[$row["Bezeichnung_studi"]][$row["Bezeichnung_modul"]][$row["Bezeichnung"]] = $row;
        }

        // print_r($uni);
        // print_r($_SESSION);
        
        #anzeigen
        foreach ($uni as $s_key => $studiengang) {
            printf('<div class="auswahl"><details><summary><b>Studiengang: %s</b> </summary></br><ul>', $s_key);
            foreach ($studiengang as $m_key => $modul) {
                printf("<li><details><summary>Modul: %s </summary></br><ul>", $m_key);
                foreach ($modul as $v_key => $Veranstaltung) {
                    printf('<li><fieldset><legend>Veranstalltung: %s </legend><ul><div class="event">', $v_key);
                    foreach ($Veranstaltung as $key => $val) {
                        // echo "$key: $val <br/>";
                        switch ($key) {
                            case "Bezeichnung_art":
                                echo ("Art: " . $val . "</br>");
                                break;
                            case "CP":
                                echo ("CP: " . $val . "</br>");
                                break;
                            case "Datum":
                                echo ("Datum: " . $val . "</br>");
                                break;
                            case "Name":
                                echo ("Dozent: " . $val . "</br>");
                                break;
                        }
                        if ($key == "Note" && $val != "") {
                            echo ("Note: " . $val . "</br>");
                        }
                    }
                    echo ("</div></ul></fieldset></li>");
                }
                echo ("</ul></details></li>");
            }
            echo ("</ul></details></div>");
        }




        ?>
    </div>
</body>

</html>