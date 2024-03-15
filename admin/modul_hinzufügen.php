<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modul hinzufügen</title>
    </head>
    <body>
        <?php
            #Setup
            session_start();
            require $_SERVER['DOCUMENT_ROOT']."/Datenbank.php";
            
            #Abmelden Knopf
            if (isset($_POST["Abmelden"])){
                $_SESSION['login'] = false;
            }
            
            #Abmelden
            if ($_SESSION['login'] == false){
                $_SESSION = array();
                header("Location: /../index.php");
                exit;
            }

            #nur Admin
            if ($_SESSION["Roll_ID"] != 3){
                echo ("<h1><Center>Du bist kein Admin</Center></h1>");
                exit;
            }
        ?>
        <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>

        <a href="/../homepage.php">Homepage</a></br>
        <h1>Modul hinzufügen:</h1>
        
        <!-- studiengang auswahl -->
        <form method="POST" action="">
            <?php
            
            # Session studiengang_temp ist dafür da, das die auswahl von Dozent oder student bleibt
            if (isset($_SESSION["studiengang_temp"]) == false){
                $_SESSION["studiengang_temp"] = 1;
            }
            # $_POST["studiengang"] deklarieren, da es sonst fehler gibt
            if (isset($_POST["studiengang"]) == false){
                $_POST["studiengang"] = $_SESSION["studiengang_temp"];
            }

            #studiengang
            echo("Studiengang:</br>");
            echo ('<select name="studiengang" onchange="this.form.submit()">'); 
            
            $query = "SELECT * FROM `studiengang`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if ($row["Studi_ID"] == $_POST["studiengang"]){
                    echo ('<option selected="selected" value="'.$row["Studi_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
                else{
                    echo ('<option value="'.$row["Studi_ID"].'">
                '.$row["Bezeichnung"].'</option>');
                }
            }
            echo ("</select></br>");
            ?>
        </form>

        <!-- Daten eintragen -->
        <form method="POST" action="">
            <?php
                #alle Module werden mit radio button angezeigt
                $query = "SELECT `modul`.*, `beinhaltet`.`Semester`, `studiengang`.`Studi_ID`
                    FROM `modul` 
                    LEFT JOIN `beinhaltet` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID` 
                    LEFT JOIN `studiengang` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID`;";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if ($row["Modul"] == $_POST["Modul"]){
                        switch ($_POST["Auswahl"]){
                            case "1":
                        }
                    }
                    echo sprintf('<input type="radio" id="%s" name="Modul" value="%s" required >
                        <label for="%s">%s</label></br>', $row["Bezeichnung"], $row["Modul_ID"], $row["Bezeichnung"], $row["Bezeichnung"]." ".$row["Semester"] );
                }

                echo ('Auswhal:</br>
                <input type="radio" id="Neu" name="Auswhal" value=1 required >
                <label for="%s">Löschen</label></br>
                <input type="radio" id="Neu" name="Auswhl" value=2 required >
                <label for="%s">Bearbeiten</label></br>
                <input type="radio" id="Neu" name="Auswahl" value=3 required >
                <label for="%s">Neu</label></br>');
                
                
            ?>
            <input type="submit" name="submit1" value="einfügen"/>
        </form>
        

        <!-- Daten verarbeiten -->
        <?php
        if (isset($_POST["suhjtgfizutfbmit1"])){

            $_POST["studiengang"] = $_SESSION["studiengang_temp"];

            #student oder dozent
            if ($_POST["studiengang"] == 1){
                $studiengang = "student";
            }
            elseif ($_POST["studiengang"] == 2){
                $studiengang = "dozent";
            }
            elseif ($_POST["studiengang"] == 3){
                $studiengang = "admin";
            }

            if ($_POST["studiengang"] != 3){

                $query = sprintf("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni' AND TABLE_NAME = '%s'; ", $studiengang);
                $result = $db->execute_query($query);   

                foreach ($result as $row) {
                    $Person_ID = $row["AUTO_INCREMENT"];
                }

                #query auswahl
                if ($_POST["studiengang"] == 1){

                    #student insert
                    $query = sprintf("INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`, `Studi_ID`) 
                    VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ", 
                    $Person_ID, $_POST["name"], $_POST["vorname"], $_POST["geburtstag"], $_POST["geschlecht"], $_POST["konfession"], $_POST["staatsangehörigkeit"], $_POST["adresse"], $_POST["studiengang"]);
                }
                elseif ($_POST["studiengang"] == 2){

                    #dozent insert
                    $query = sprintf("INSERT INTO `dozent` (`Dozi_ID`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Adress_ID`) 
                    VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '2') ", 
                    $Person_ID, $_POST["name"], $_POST["vorname"], $_POST["geburtstag"], $_POST["geschlecht"], $_POST["konfession"], $_POST["staatsangehörigkeit"], $_POST["adresse"]);
                }
                
                #einfügen
                if ($db->execute_query($query) === true) {
                    echo ("$studiengang success</br>");
                }
                else {
                    echo ($db->error);
                }
            }
            
            #benutzer_ID einfügen
            $query = ("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni' AND TABLE_NAME = 'benutzer_ID'; ");
            $result = $db->execute_query($query);   

            foreach ($result as $row) {
                $Ben_ID = $row["AUTO_INCREMENT"];
            }

            if ($_POST["studiengang"] == 1){
                $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Studi_ID`, `student_ID`, `dozent_ID`) VALUES ($Ben_ID, '%s', '%s', NULL)", $_POST["studiengang"], $Person_ID); 
            }
            elseif ($_POST["studiengang"] == 2){
                $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Studi_ID`, `student_ID`, `dozent_ID`) VALUES ($Ben_ID, '%s', NULL, '%s')", $_POST["studiengang"], $Person_ID); 
            }
            elseif ($_POST["studiengang"] == 3){
                $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `Studi_ID`, `student_ID`, `dozent_ID`) VALUES ($Ben_ID, '%s', NULL, Null)", $_POST["studiengang"]); 
            }

            if ($db->execute_query($query) === true) {
                echo ("benutzer success</br>");
                $random = rand();
                echo ("<a href='http://localhost/registrieren.php?ID=".hash_hmac('sha256', $Ben_ID, $random)."'>Registrieren</a></br>");
                echo ("Admin Code: ".$random);
            }
            else {
                echo ($db->error);
            } 

            $_SESSION["studiengang_temp"] = NULL;
        }
        else{
            $_SESSION["studiengang_temp"] = $_POST["studiengang"];
        }
        ?>
        </body>
</html>