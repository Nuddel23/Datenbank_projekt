<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div class="calender">
            <?php
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

                #Veranstaltungen anzeigen
                $query= 
                    "SELECT `student`.`Matrikelnummer`, `student_konver`.`Note`, `konkrete_veranstaltung`.`Datum`, `veranstaltung`.*, `dozent`.`Name`
                    FROM `student` 
                        LEFT JOIN `student_konver` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer` 
                        LEFT JOIN `konkrete_veranstaltung` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
                        LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                        LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID`;";
                
                $result = $db->execute_query($query);
                #print_r ($result);
                foreach ($result as $row){
                    #print_r($row);
                    echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                    foreach($row as $key => $val){
                        echo "$key:    $val <br/>";
                    }
                    echo ("</br></div></div></div></div>");
                }
                echo ('</div>')
            ?>
        </div>
    </body>
</html>