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
        <h1>Konkrete Veranstaltung erstellem:</h1>
        <?php

        $query = "SELECT `veranstaltung`.*, `konkrete_veranstaltung`.`KonVer_ID`, `konkrete_veranstaltung`.`Datum`, `konkrete_veranstaltung`.`Semi_ID`, `veranstaltungsart`.`Bezeichnung_art`
            FROM `veranstaltung` 
            LEFT JOIN `konkrete_veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
            LEFT JOIN `veranstaltungsart` ON `veranstaltung`.`Art_ID` = `veranstaltungsart`.`Art_ID`;";

        $result = $db->execute_query($query);

        echo ('<form method="POST" action="">');
        echo ('<select name="Veranstaltungs_ID" onchange="this.form.submit()">'); 
                        
        # Veranstaltung auswahl
        foreach ($result as $row){
            if ($row["KonVer_ID"] == NULL) {
                if (isset($_POST["Veranstaltungs_ID"]) == false){
                    $_POST["Veranstaltungs_ID"] = $row["Veranstaltungs_ID"];
                }

                if ($row["Veranstaltungs_ID"] == $_POST["Veranstaltungs_ID"]){
                    echo ('<option selected="selected" value="'.$row["Veranstaltungs_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
                else{
                    echo ('<option value="'.$row["Veranstaltungs_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
            }
        }
        #Veranstaltung Beschtreibung
        echo ("</select></br>");
        foreach ($result as $row){
            if ($row["Veranstaltungs_ID"] == $_POST["Veranstaltungs_ID"]){
                echo ("Bezeichnung: ".$row["Bezeichnung"]."</br>");
                echo ("CP: ".$row["CP"]."</br>");
                echo ("Veranstaltungsart: ".$row["Bezeichnung_art"]."</br>");
                // foreach($row as $key => $val){
                //     echo "$key: $val <br/>";
                // }
            }
        }


        // printf('<input type="hidden" id="Veranstaltungs_ID" name="Veranstaltungs_ID" value="%s">', $_POST["Veranstaltungs_ID"]);
        echo ('</form>')
        
        ?>
    </body>
</html>