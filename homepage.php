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
            $session_row = $_SESSION['benutzer'];
            $db = new mysqli('localhost', 'root', '', 'uni');

            #Abmelden Knopf
            if (isset($_POST["Abmelden"])){
                $_SESSION['login'] = false;
            }
            
            #Abmelden
            if ($_SESSION['login'] == false){
                unset($_SESSION['benutzer']);
                unset($_SESSION["Roll_ID"]);
                header("Location: index.php");
                exit;
            }

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
                if ($row['Ben_ID'] == $session_row['Ben_ID']){
                    
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
            #Admin Panel
            if ($_SESSION["Roll_ID"] == 3){
                echo ('<a href="benutzer_erstellen.php">Benuter erstellen </a>');
                echo ('<a href="adresse_hinzufügen.php">Adrese hinzufügen </a>');
            }
            else {
                echo ('<a href="Veranstaltungen.php">Veranstaltungen </a> ');
            }
        ?>
    </body>
</html>