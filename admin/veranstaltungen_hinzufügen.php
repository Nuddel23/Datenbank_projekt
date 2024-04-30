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
        <h1>Veranstaltung erstellem:</h1>
            <?php

            #Studiengang auswahl
            echo("Studiengang:");
            echo ('<select name="Studi_ID" onchange="this.form.submit()">'); 
            
            $query = "SELECT * FROM `studiengang`";
            $result = $db->execute_query($query);

            if (isset($_POST["Studi_ID"]) == false){
                $_POST["Studi_ID"] = 1;
            }

            foreach ($result as $row) {
                if ($row["Studi_ID"] == $_POST["Studi_ID"]){
                    echo ('<option selected="selected" value="'.$row["Studi_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
                else{
                    echo ('<option value="'.$row["Studi_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
            }
            echo ("</select></br>");

            #Modul auswahl
            echo("Modul:");
            echo ('<select name="Modul_ID" onchange="this.form.submit()">'); 
            
            $query = sprintf("SELECT `studiengang`.*, `beinhaltet`.*, `modul`.*
            FROM `studiengang` 
                LEFT JOIN `beinhaltet` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID` 
                LEFT JOIN `modul` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID`
            WHERE `studiengang`.`Studi_ID` = '%s';", $_POST["Studi_ID"]);
            $result = $db->execute_query($query);

            if (isset($_POST["Modul_ID"]) == false){
                $_POST["Modul_ID"] = 1;
            }

            foreach ($result as $row) {
                if ($row["Modul_ID"] == $_POST["Modul_ID"]){
                    echo ('<option selected="selected" value="'.$row["Modul_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
                else{
                    echo ('<option value="'.$row["Modul_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
            }
            echo ("</select></br>");
            echo ('<form method="POST" action="">');


            #Veranstaltungsart
            echo ("Veranstaltungsart:");
            echo ('<select name="Art_ID">');
            $query = "SELECT * FROM `veranstaltungsart`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                echo ('<option value="'.$row["Art_ID"].'">
                '.$row["Bezeichnung_art"].'</option>');
            }
            echo ("</select></br>");
            
            ?>
            Bezeichnung:
            <input type="text" name="Bezeichnung"></input></br>
            CP:
            <input type="number" name="CP"></input></br>
            <input type="submit" name="submit" value="einfügen"/>
        </form>

        <!-- Daten Verarbeiten -->
        <?php
            if (isset($_POST["submit"])){
                $query = sprintf("INSERT INTO `veranstaltung` (`Veranstaltungs_ID`, `Bezeichnung`, `CP`, `Modul_ID`, `Art_ID`) VALUES (NULL, '%s', '%s', '%s', '%s') ", 
                $_POST["Bezeichnung"], $_POST["CP"], $_POST["Modul_ID"], $_POST["Art_ID"]);
                #einfügen
                if ($db->execute_query($query) === true) {
                    echo ('Veranstalltung success</br>');
                }
                else {
                    echo ($db->error);
                }
            }
        ?>
    </body>
</html>