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
                echo ('Note success</br>');
            } else {
                echo ($db->error);
            }
        }






        $query = "SELECT `konkrete_veranstaltung`.*, `veranstaltung`.`Bezeichnung`, `student_konver`.*, `student`.*
        FROM `konkrete_veranstaltung` 
            LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
            LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
            LEFT JOIN `student` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer`;";

        $result = $db->execute_query($query);


        # sotieren
        $student = array();
        $ver = array();

        foreach ($result as $row) {
            if ($row["KonVer_ID"] != NULL) {
                $student[$row["KonVer_ID"]][$row["Vorname"] . " " . $row["Name"]][$row["Matrikelnummer"]] = $row["Note"];
            }
        }
        #print_r($student);
        
        foreach ($result as $row) {
            $ver[$row["KonVer_ID"]] = $row;
        }
        #print_r($ver);
        

        foreach ($ver as $row) {
            echo ('<div class="auswahl"><div class="event"><fieldset>');
            foreach ($row as $key => $val) {
                // echo "$key: $val <br/>";
                switch ($key) {
                    case "Bezeichnung":
                        if (strtotime($row["Datum"]) < time()) {
                            echo ('<legend class="teilgenommen">' . $val . "</legend>");
                        } else {
                            echo ('<legend>' . $val . "</legend>");
                        }

                        break;
                    case "Datum":
                        echo ("Datum: " . $val . "</br>");
                        break;
                    case "KonVer_ID":
                        echo ("Student: <ul>");
                        if ($val != NULL) {
                            foreach ($student[$val] as $stu => $nr) {
                                echo ("<li>" . $stu . "</br></li>");
                                if (strtotime($row["Datum"]) < time()) {
                                    echo ('
                                    <form method="POST" action="">
                                    Note: <select name="Note" onchange="this.form.submit()">');

                                    for ($i = 1; $i < 6; $i++) {
                                        foreach ($nr as $nr_key => $note) {
                                            if ($i == $note) {
                                                echo ('<option selected="selected" value="' . $i . '">
                                            ' . $i . '</option>');
                                            } else {
                                                echo ('<option value="' . $i . '">
                                            ' . $i . '</option>');
                                            }
                                        }
                                    }
                                    if ($note == NULL) {
                                        echo ('<option selected="selected" value="' . NULL . '">
                                    ' . NULL . '</option>');
                                    } else {
                                        echo ('<option value="' . NULL . '">
                                    ' . NULL . '</option>');
                                    }


                                    echo ("</select>");
                                    printf('<input type="hidden" name="KonVer_ID" value="%s">', $val);
                                    printf('<input type="hidden" name="Matrikelnummer" value="%s">', $nr_key);
                                    echo ("</br></form>");
                                }
                            }
                        }
                        echo ("</ul>");
                        break;
                }
            }
            echo ("</fieldset></div></div>");
        }
        echo ('</div>');

        ?>
</body>

</html>