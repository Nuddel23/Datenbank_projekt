<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/page.css?v=<?php echo time(); ?>">
        <title> Kalender </title>
    </head>
    <body>
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

            echo ("<h1><Center>Hallo ");

            #Rollen auswahl
            switch ($session_row['Roll_ID']){
                case 1:      
                    $query = 
                        "SELECT `student`.*, `benutzer`.*
                        FROM `student` 
                        LEFT JOIN `benutzer` ON `student`.`ben_ID` = `benutzer`.`ID`;";
                    break;
                case 2:
                    $query = 
                        "SELECT `dozent`.*, `benutzer`.*
                        FROM `dozent` 
                        LEFT JOIN `benutzer` ON `dozent`.`ben_ID` = `benutzer`.`ID`;";
                    break;
                case 3:
                    $query=
                        "SELECT `benutzer`.*
                        FROM `benutzer`;";
                    echo ("Admin"."</Center></h1>");
                    break;
            }
            $result = $db->execute_query($query);
            
            foreach($result as $row){
                if ($row['ID'] == $session_row['ID']){
                    
                    $_SESSION['benutzer'] = $row;
                    
                    if ($row['Roll_ID'] != "3"){
                        echo ($row['Name']."</Center></h1>");
                    }   
                }
                #print_r($row);
            }
        ?>

        <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>

        <div class="calender">
            <?php
                #Zeiten
                echo ('<div class="timeline">');
                for ($i = 1; $i <= 10; $i++) {
                    echo ('<div class="time-marker">10 AM</div>');
                }
                echo ('</div>');

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
                    echo ('<div class="event"></br>');
                    foreach($row as $key => $val){
                        echo "$key:    $val <br/>";
                    }
                    echo ("</br></div>");
                }
            ?>
        </div>
    </body>
</html>