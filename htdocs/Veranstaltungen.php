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
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>
        <a href="homepage.php">Homepage</a> 
        <div class="calender">
            <?php
                #Setup
                session_start();
                $session_row = $_SESSION['benutzer'];
                $db = new mysqli('localhost', 'root', '', 'uni');

                #Abmelden Knopf
                if (isset($_POST["Abmelden"])){
                   $_SESSION['login'] = false;
                }
            
                #Abmelden
                if ($_SESSION['login'] == false){
                    $_SESSION['benutzer'] = array();
                    header("Location: index.php");
                    exit;
                }

                #Zeiten
                #echo ('<div class="timeline">');
                #for ($i = 1; $i <= 10; $i++) {
                #    echo ('<div class="time-marker">'.$i.' AM</div>');
                #}
                #echo ('</div> <div class="days>"');

                if($session_row["Roll_ID"] == 3){
                    exit;
                }

                #Veranstaltungen anzeigen
                $query= sprintf(
                    "SELECT `student`.`Matrikelnummer`, `student_konver`.`Note`, `konkrete_veranstaltung`.`Datum`, `veranstaltung`.*, `dozent`.`Name`
                    FROM `student` 
                        LEFT JOIN `student_konver` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer` 
                        LEFT JOIN `konkrete_veranstaltung` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
                        LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                        LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID`
                        WHERE `student`.`Matrikelnummer` = '%s';", $session_row["Matrikelnummer"]);
                
                $result = $db->execute_query($query);
                #print_r ($result);
                foreach ($result as $row){
                    #print_r($row);
                    echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                    foreach($row as $key => $val){
                        echo "$key: $val <br/>";
                    }
                    echo ("</br></div></div></div></div>");
                }
                echo ('</div>');
            ?>
        </div>
    </body>
</html>