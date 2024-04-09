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
        <form method="post" action="">
            <?php
            #TODO in studiengang umwandeln
                $query = "SELECT * FROM `studiengang`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo sprintf('<input type="radio" id="%s" name="studiengang" value="%s" required >
                        <label for="%s">%s</label></br>', $row["Bezeichnung"], $row["Modul_ID"], $row["Bezeichnung"], $row["Bezeichnung"]);
                }

            #TODO in Semester umwandeln
            echo("Studiengang: ");
            echo ('<select name="Semester">'); 
            
            $query = "SELECT * FROM `studiengang`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if (isset($_POST["studiengang"]) == false){
                    $_POST["studiengang"] = $row["Studi_ID"];
                }

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
            Modulname: <input type="text" name="Modul_name" required /></br>
            <input type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
            if (isset($_POST["submit"])){
 
                #Prüfen ob es das Modul schon gibt
                $query = 
                    "SELECT * FROM `modul`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {  
                    if ($row["Bezeichnung"] == $_POST["Modul_name"]) {
                        echo ("Modul exestiert bereits </br>");
                        exit;
                    }
                }

                #Addresse einfügen
                $query = sprintf("INSERT INTO `modul` (`Modul_ID`, `Bezeichnung`) VALUES (NULL, '%s')", $_POST["Modul_name"]);

                if ($db->execute_query($query) === true) {
                    echo ("PLZ success </br>");
                }
                else {
                    echo ($db->error);
                }

                $query = sprintf("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'uni' AND TABLE_NAME = 'modul'; ");
                $result = $db->execute_query($query);   

                foreach ($result as $row) {
                    $Modul_ID = $row["AUTO_INCREMENT"];
                }
            }
        ?>
    </body>
</html>