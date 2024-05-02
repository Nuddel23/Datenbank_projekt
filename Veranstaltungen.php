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

        #Veranstaltungen anzeigen
        $benutzer = $_SESSION["benutzer"];
        $query =
            "SELECT `veranstaltung`.*, `konkrete_veranstaltung`.*, `dozent`.`Name`, `student_konver`.*
                FROM `veranstaltung` 
                LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID` 
                LEFT JOIN `student_konver` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID`;
                    ";

        $result = $db->execute_query($query);

        foreach ($result as $row) {
            if ($benutzer["Matrikelnummer"] == $row["Matrikelnummer"]) {
                echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                foreach ($row as $key => $val) {
                    echo "$key: $val <br/>";
                }
                echo ("</br></div></div></div></div>");
                echo ("ende von Teilgenommene");

            } elseif ($row["KonVer_ID"] == NULL && strtotime($row["Datum"]) > time()) {
                echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                foreach ($row as $key => $val) {
                    echo "$key: $val <br/>";
                }
                echo ("</br></div></div></div></div>");
                echo ("ende geplant");
                
            } elseif ($row["KonVer_ID"] == NULL && strtotime($row["Datum"]) == NULL) {
                echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                foreach ($row as $key => $val) {
                    echo "$key: $val <br/>";
                }
                echo ("</br></div></div></div></div>");
            }
            echo ('</div>');
        }
        ?>
        </div>
</body>

</html>