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
            $session_row = $_SESSION['benutzer'];
            $db = new mysqli('localhost', 'root', '', 'uni');
            
            #Abmelden Knopf
            if (isset($_POST["Abmelden"])){
                $_SESSION['login'] = false;
            }
            
            #Abmelden
            /*if ($_SESSION['login'] == false){
                unset($_SESSION['benutzer']);
                unset($_SESSION["Roll_ID"]);
                header("Location: index.php");
                exit;
            }

            #nur Admin
            if ($_SESSION["Roll_ID"] != 3){
                echo ("<h1><Center>Du bist kein Admin</Center></h1>");
                exit;
            }*/
        ?>
        <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>

        <a href="homepage.php">Homepage</a></br>
        <h1>Student Anmeldung:</h1>

        <form method="POST" action="">
            <?php
            
            # Session rolle_temp ist dafür da, das die auswahl von Dozent oder student bleibt
            if (isset($_SESSION["rolle_temp"]) == false){
                $_SESSION["rolle_temp"] = 1;
            }
            # $_POST["rolle"] deklarieren, da es sonst fehler gibt
            if (isset($_POST["rolle"]) == false){
                $_POST["rolle"] = $_SESSION["rolle_temp"];
            }

            #Rolle
            echo("Rolle:</br>");
            echo ('<select name="rolle" onchange="this.form.submit()">'); 
            
            $query = "SELECT * FROM `rollen`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if ($row["Roll_ID"] == $_POST["rolle"]){
                    echo ('<option selected="selected" value="'.$row["Roll_ID"].'">
                '.$row["Rolle"].'</option>');
                }
                else{
                    echo ('<option value="'.$row["Roll_ID"].'">
                '.$row["Rolle"].'</option>');
                }
            }
            echo ("</select></br>");
            ?>
        </form>

        <form method="POST" action="">
            Name: <input type="text" name="name" required /></br>
            Vorname: <input type="text" name="vorname" required /></br>
            Geburtsdatum: <input type="date" name="geburtstag" required /></br>
            <input type="radio" id="mänlich" name="geschlecht" value="mänlich" required >
            <label for="mänlich">Mänlich</label>
            <input type="radio" id="weiblich" name="geschlecht" value="weiblich" required >
            <label for="weiblich">Weiblich</label><br>
            Konfession: <input type="text" name="konfession" required /></br>
            Staatsangehörigkeit: <input type="text" name="staatsangehörigkeit" required /></br>
            <?php

                #Adresse
                echo("Adresse:</br>");
                echo ('<select name="adresse">');
                $query = "SELECT * FROM `adresse`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<option value="'.$row["Adress_ID"].'">
                    '.$row["Straße"].' '.$row["Hausnummer"].' '.$row["PLZ"].'</option>');
                }
                echo ("</select></br>");

                #Studiengang
                if ($_POST["rolle"] == 1){                    
                    echo ("Studiengänge:</br>");
                    echo ('<select name="studiengang">');
                    $query = "SELECT * FROM `studiengang`";
                    $result = $db->execute_query($query);

                    foreach ($result as $row) {
                        echo ('<option value="'.$row["Studi_ID"].'">
                        '.$row["Bezeichnung"].'</option>');
                    }
                    echo ("</select></br>");
                }
               
            ?>
            </br>
            <input type="submit" name="submit1" value="einfügen"/>
        </form>

        <?php
        if (isset($_POST["submit1"])){

            $_POST["rolle"] = $_SESSION["rolle_temp"];

            #studdent oder dozent
            if ($_POST["rolle"] == 1){
                $rolle = "student";
            }
            elseif ($_POST["rolle"] == 2){
                $rolle = "dozent";
            }

            $query = sprintf("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni' AND TABLE_NAME = '%s'; ", $rolle);
            $result = $db->execute_query($query);   

            foreach ($result as $row) {
                $Person_ID = $row["AUTO_INCREMENT"];
            }

            #query auswahl
            if ($_POST["rolle"] == 1){

                #student insert
                $query = sprintf("INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`, `Studi_ID`) 
                VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ", 
                $Person_ID, $_POST["name"], $_POST["vorname"], $_POST["geburtstag"], $_POST["geschlecht"], $_POST["konfession"], $_POST["staatsangehörigkeit"], $_POST["adresse"], $_POST["studiengang"]);
            }
            elseif ($_POST["rolle"] == 2){

                #dozent insert
                $query = sprintf("INSERT INTO `dozent` (`Dozi_ID`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`) 
                VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '2') ", 
                $Person_ID, $_POST["name"], $_POST["vorname"], $_POST["geburtstag"], $_POST["geschlecht"], $_POST["konfession"], $_POST["staatsangehörigkeit"], $_POST["adresse"]);
            }
            
            #einfügen
            if ($db->execute_query($query) === true) {
                echo ("$rolle success</br>");
            }
            else {
                echo (mysqli::error);
            }
            
            #benutzer_ID einfügen
            if ($_POST["rolle"] == 1){
                $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES (NULL, '%s', '%s', NULL)", $_POST["rolle"], $Person_ID); 
            }
            elseif ($_POST["rolle"] == 2){
                $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Roll_ID`, `student_ID`, `dozent_ID`) VALUES (NULL, '%s', NULL, '%s')", $_POST["rolle"], $Person_ID); 
            }

            if ($db->execute_query($query) === true) {
                echo ("benutzer success</br>");
            }
            else {
                echo (mysqli::error);
            } 

            $_SESSION["rolle_temp"] = NULL;
        }
        else{
            $_SESSION["rolle_temp"] = $_POST["rolle"];
        }
        ?>
    </body>
</html>