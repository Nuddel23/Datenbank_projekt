<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homepage</title>
    </head>
    <body>
        <?php
            #Setup
            session_start();
            require $_SERVER['DOCUMENT_ROOT']."/Datenbank.php";

            $AdminOnly = false;
            require $_SERVER['DOCUMENT_ROOT']."/Anmelden.php";

            echo ("<h1><Center>Hallo ");

            #Rollen auswahl
            switch ($_SESSION['Roll_ID']){
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
                    $query=
                        "SELECT `benutzer_id`.*
                        FROM `benutzer_id`;";
                    echo ("Admin"."</Center></h1>");
                    break;
            }
            $result = $db->execute_query($query);
            
            foreach($result as $row){
                if ($row['Ben_ID'] == $_SESSION["benutzer"]['Ben_ID']){
                    
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
        <?php            
            #auf Rolle basierte Seiten
            switch($_SESSION["Roll_ID"]){
                case 1: //student
                    echo ('</br><a href="Veranstaltungen.php">Veranstaltungen </a> ');
                    break;
                case 2: //dozent
                    break;
                case 3: //admin
                    echo ('</br><a href="admin/benutzer_hinzufügen.php">Benuter erstellen </a>');
                    echo ('</br><a href="admin/studiengang_hinzufügen.php">Studiengang hinzufügen </a>');
                    echo ('</br><a href="admin/modul_hinzufügen.php">Modul hinzufügen </a>');
                    echo ('</br><a href="admin/veranstaltungen_hinzufügen.php">Veranstaltung hinzufügen </a>');
                    echo ('</br><a href="admin/konkrete_veranstaltungen_hinzufügen.php">Veranstaltung hinzufügen </a>');
                    break;
            }
        ?>
    </body>
</html>