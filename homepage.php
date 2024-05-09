<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homepage.css?v=<?php echo time(); ?>">
    <title>Homepage</title>
</head>

<body>
    <?php
    #Setup
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

    $AdminOnly = false;
    require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";

    #Rollen auswahl
    switch ($_SESSION['Roll_ID']) {
        case 1:
            $query =
                "SELECT `student`.*, `benutzer_id`.*
                            FROM `student` 
                            LEFT JOIN `benutzer_id` ON `benutzer_id`.`student_ID` = `student`.`Matrikelnummer`;";
            break;
        case 2:
            $query =
                "SELECT `dozent`.*, `benutzer_id`.*
                            FROM `dozent` 
                            LEFT JOIN `benutzer_id` ON `benutzer_id`.`dozent_ID` = `dozent`.`Dozi_ID`;";
            break;
        case 3:
            $query =
                "SELECT `benutzer_id`.*
                            FROM `benutzer_id`;";
            break;
    }
    $result = $db->execute_query($query);

    foreach ($result as $row) {
        if ($row['Ben_ID'] == $_SESSION["benutzer"]['Ben_ID']) {

            $_SESSION['benutzer'] = $row;
        }
    }

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
        <div class="textbox">
            <?php
            echo ("<h1><Center>Hallo ");

            foreach ($result as $row) {
                if ($row['Ben_ID'] == $_SESSION["benutzer"]['Ben_ID']) {

                    $_SESSION['benutzer'] = $row;

                    if ($row['Roll_ID'] != "3") {
                        echo ($row['Name'] . "</Center></h1>");
                    } else {
                        echo ("Admin" . "</Center></h1>");
                    }
                }
                #print_r($row);
            }
            ?>
            <!-- <p>test</p> -->
        </div>
    </section>
</body>

</html>