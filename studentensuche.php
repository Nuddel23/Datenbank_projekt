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
                            echo ('<li><a href="studentensuche.php">Studentensuche </a></li> ');
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
        <form action="" method="post">
            <input type="search" placeholder="Matrikelnummer" id="search1" name="Matrikelnummer">
            <input type="search" placeholder="Name" id="search2" name="Name">
            <input type="search" placeholder="Vorname" id="search3" name="Vorname">
            <input type="submit" value="Suche">
        </form>

        <?php





        if (isset($_POST["Note"])) {
            $query = sprintf(
                "UPDATE `student_konver` SET `KonVer_ID` = '%s', `Matrikelnummer` = '%s', `Note` = '%s' WHERE `student_konver`.`KonVer_ID` = %s AND `student_konver`.`Matrikelnummer` = %s ",
                $_POST["KonVer_ID"],
                $_POST["Matrikelnummer"],
                $_POST["Note"],
                $_POST["KonVer_ID"],
                $_POST["Matrikelnummer"]
            );

            if ($db->execute_query($query) === true) {
                #echo ('Note success</br>');
            } else {
                echo ($db->error);
            }
        }


        $query = "SELECT `konkrete_veranstaltung`.*, `veranstaltung`.`Bezeichnung`, `student_konver`.*, `student`.`Matrikelnummer`
        FROM `konkrete_veranstaltung` 
            LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
            LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
            LEFT JOIN `student` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer`;";

        $result = $db->execute_query($query);

        if (isset($_POST["Name"])) {
            if ($_POST["Matrikelnummer"] . $_POST["Name"] . $_POST["Vorname"] != NULL) {
                $query = sprintf("SELECT `student`.*
            FROM `student`
            WHERE `student`.`Matrikelnummer` = '%s' OR `student`.`Name` = '%s' OR `student`.`Vorname` = '%s';", $_POST["Matrikelnummer"], $_POST["Name"], $_POST["Vorname"]);
            } else {
                $query = "SELECT `student`.*
                FROM `student`";
            }
        } else {
            $query = "SELECT `student`.*
            FROM `student`";
        }
        $info = $db->execute_query($query);


        # sotieren
        $student = array();

        foreach ($result as $row) {
            foreach ($info as $stu)
                if ($row["Matrikelnummer"] == $stu["Matrikelnummer"]) {
                    $student[$row["Matrikelnummer"]]["info"] = $stu;
                    $student[$row["Matrikelnummer"]]["KonVer"][$row["KonVer_ID"]] = $row;
                }
        }

        foreach ($student as $ma) {
            echo ('<div class="auswahl"><div class="event"><fieldset>');
            foreach ($ma as $typ => $v_typ) {
                if ($typ == "info") {
                    foreach ($v_typ as $k_info => $v_info) {
                        if ($k_info == "Name") {
                            echo ('<legend class="teilgenommen">' . $v_info . "</legend>");
                            echo ($k_info . " " . $v_info . "</br>");
                        } else {
                            echo ($k_info . " " . $v_info . "</br>");
                        }
                    }
                } elseif ($typ == "KonVer") {
                    foreach ($v_typ as $key_kon => $kon) {

                        echo ("</br><fieldset>");
                        foreach ($kon as $k_kon => $v_kon) {
                            if ($k_kon == "Datum") {
                                echo ($k_kon . " " . $v_kon . "</br>");
                                if (strtotime($v_kon) < time()) {
                                    echo ('
                                    <form method="POST" action="">
                                    Note: <select name="Note" onchange="this.form.submit()">');

                                    for ($i = 1; $i < 6; $i++) {
                                        if ($i == $kon["Note"]) {
                                            echo ('<option selected="selected" value="' . $i . '">
                                            ' . $i . '</option>');
                                        } else {
                                            echo ('<option value="' . $i . '">
                                            ' . $i . '</option>');
                                        }
                                    }
                                    if ($kon["Note"] == NULL) {
                                        echo ('<option selected="selected" value="' . NULL . '">
                                        ' . NULL . '</option>');
                                    } else {
                                        echo ('<option value="' . NULL . '">
                                        ' . NULL . '</option>');
                                    }

                                    echo ("</select>");
                                    printf('<input type="hidden" name="KonVer_ID" value="%s">', $key_kon);
                                    printf('<input type="hidden" name="Matrikelnummer" value="%s">', $kon["Matrikelnummer"]);
                                    echo ("</br></form>");

                                }
                            } else if ($k_kon == "Bezeichnung") {
                                echo ('<legend class="teilgenommen">' . $v_kon . "</legend>");
                            } else {
                                #echo ($k_kon . " " . $v_kon . "</br>");
                            }
                        }
                        echo ("</fieldset>");
                    }
                }

            }
            echo ("</fieldset></div></div>");
        }
        echo ('</div>');

        ?>
    </div>
</body>

</html>