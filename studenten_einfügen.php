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
            $db = new mysqli('localhost', 'root', '', 'uni_neu');
            
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
            Name: <input type="text" name="name"/></br>
            Vorname: <input type="text" name="vorname"/></br>
            Geburtsdatum: <input type="date" name="geburtstag"/></br>
            <input type="radio" name="geschlecht" value="mänlich">
            Mänlich<br>
            <input type="radio" name="geschlecht" value="weiblich">
            Weiblich<br>
            Konfession: <input type="text" name="konfession"/></br>
            Staatsangehörigkeit: <input type="text" name="staatsangehörigkeit"/></br>
            <?php
                #Studiengang
                echo ("Studiengänge:</br>");
                $query = "SELECT * FROM `studiengang`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<input type="radio" name="studiengang" value="'.$row["Studi_ID"].'">
                    '.$row["Bezeichnung"].'<br>');
                }

                #Adresse
                echo ("Adresse:</br>");
                $query = "SELECT * FROM `adresse`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<input type="radio" name="adresse" value="'.$row["Adress_ID"].'">
                    '.$row["Straße"].' '.$row["Hausnummer"].' '.$row["PLZ"].'<br>');
                }
            ?>
            <input type="submit" name="submit" value="einfügen"/>
        </form>

        <?php
        if (isset($_POST["submit"])){
            
            #studien_ID
            $query = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni_neu' AND TABLE_NAME = 'student'; ";
            $result = $db->execute_query($query);   

            foreach ($result as $row) {
                $Matrikelnummer = $row["AUTO_INCREMENT"];
            }

            #student insert
            $query = sprintf("INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Studi_ID`, `Adress_ID`)
            VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ", 
            $Matrikelnummer, $_POST["name"], $_POST["vorname"], $_POST["geburtstag"], $_POST["geschlecht"], $_POST["konfession"], $_POST["staatsangehörigkeit"], $_POST["studiengang"], $_POST["adresse"]);
            
            if ($db->execute_query($query) === true) {
                echo ("student success</br>");
            }
            else {
                echo (mysqli::error);
            }
            
            #benutzer_ID insert
            $query = sprintf("INSERT INTO `benutzer_id` (`Ben_ID`, `student_ID`, `dozent_ID`) VALUES (NULL, '".($Matrikelnummer)."', NULL) ", );    
            if ($db->execute_query($query) === true) {
                echo ("benutzer success</br>");
            }
            else {
                echo (mysqli::error);
            } 

            
        }
        ?>
    </body>
</html>