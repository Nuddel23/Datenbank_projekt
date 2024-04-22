<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <?php
            #Setup
            session_start();
            require $_SERVER['DOCUMENT_ROOT']."/Datenbank.php";
            
            $AdminOnly = true;
            require $_SERVER['DOCUMENT_ROOT']."/Anmelden.php";
        ?>
        <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>

        <a href="/../homepage.php">Homepage</a></br>
        <h1>Konkrete veranstaltung erstellem:</h1>
        <?php

        $query = "SELECT `veranstaltung`.*, `konkrete_veranstaltung`.*, `dozent`.`Name`
            	FROM `veranstaltung` 
                LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID`;";

        $result = $db->execute_query($query);

        foreach ($result as $row){
            if ($row["KonVer_ID"] == NULL) {
                echo ('<div class="day"><div class="event"><div class="event start-2 end-5 securities"><div class="title"></br>');
                foreach($row as $key => $val){
                    if ($key == "Datum"){
                        echo ('<input type="date" name=".$row["Veranstaltungs_ID"].datum"/></br>');
                    }
                    else if ($key == "Dozi_ID"){
                        #dozent auswahl
                        $query = "SELECT * FROM `dozent`";
                        $result = $db->execute_query($query);
                        echo ('<select name="dozent">'); 

                        foreach ($result as $row) {
                            echo ('<option selected="selected" value="'.$row["Dozi_ID"].'">
                            '.$row["Name"]." ".$row["Dozi_ID"].'</option>');
                        }
                        echo ('<select name="dozent">'); 
                    }
                    else{
                        echo "$key: $val <br/>";
                    }
                    
                }
                echo ("</br></div></div></div></div>");
            }
            echo ('</div>');
        }
        ?>
    </body>
</html>