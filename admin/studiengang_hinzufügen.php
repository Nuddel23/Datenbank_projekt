<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/homepage.css?v=<?php echo time(); ?>">
    <title>Studiengang hinzufügen</title>
</head>

<body>
    <?php
    #Setup
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

    $AdminOnly = true;
    require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";
    ?>
    <section class="header">
        <nav>
            <a href="../homepage.php"><img src="../img/logo-2.png"></a>
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
                            echo ('<li><a href="benutzer_hinzufügen.php">Benuter erstellen </a></li>');
                            echo ('<li><a href="studiengang_hinzufügen.php">Studiengang hinzufügen </a></li>');
                            echo ('<li><a href="modul_hinzufügen.php">Modul hinzufügen </a></li>');
                            echo ('<li><a href="veranstaltungen_hinzufügen.php">Veranstaltung hinzufügen </a></li>');
                            echo ('<li><a href="konkrete_veranstaltungen_hinzufügen.php">konkret Veranstaltung hinzufügen </a></li>');
                            break;
                    }
                    ?>
                    <li><a href="../homepage.php">HOME</a></li>
                    <li>
                        <form method="post" action="">
                            <input class="submitlink" type="submit" name="Abmelden" value="Abmelden" />
                        </form>
                    </li>
                </ul>
        </nav>
        <div class="admin">
            <h1>Studiengang hinzufügen</h1>
            </br>

        <form method="post" action="">
            <input type="text" placeholder="Bezeichnung" name="Bezeichnung" required /></br>
            <input class="submit" type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
        if (isset($_POST["submit"])) {
            $query = "SELECT * FROM studiengang";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if ($row["Bezeichnung"] == $_POST["Bezeichnung"]) {
                    echo ("Studiengang exestiert bereits");
                    exit;
                }
            }

            $query = sprintf("INSERT INTO `studiengang` (`Studi_ID`, `Bezeichnung`) 
                VALUES (Null, '%s') ", $_POST["Bezeichnung"]);

            if ($db->execute_query($query) === true) {
                echo ("success");
                $_POST = array();
            } else {
                echo ($db->error);
            }
        }
        ?>
</body>

</html>