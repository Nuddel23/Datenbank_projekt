<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a href="Veranstaltungen.php">Veranstaltungen</a> 
    </body>
</html>