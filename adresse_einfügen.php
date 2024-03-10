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
            if ($_SESSION['login'] == false){
                unset($_SESSION['benutzer']);
                unset($_SESSION["Roll_ID"]);
                header("Location: index.php");
                exit;
            }

            #nur Admin
            if ($_SESSION["Roll_ID"] != 3){
                echo ("<h1><Center>Du bist kein Admin</Center></h1>");
                exit;
            }
        ?>
        <!-- <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from> -->

        <a href="homepage.php">Homepage</a></br>
        <h1>Student Anmeldung:</h1>
        <form method="post" action="">
            Straße: <input type="text" name="Straße" required /></br>
            Hausnummer: <input type="text" name="Hausnummer" required /></br>
            PLZ: <input type="text" name="PLZ" required /></br>
            Ort: <input type="text" name="Ort" required /></br>
            <input type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
            if (isset($_POST["submit"])){
 
                #Prüfen ob es die Adresse oder PLZ schon gibt
                $query = 
                    "SELECT `adresse`.`Adress_ID`, `adresse`.`Straße`, `adresse`.`Hausnummer`, `plz`.*
                    FROM `adresse` 
                        LEFT JOIN `plz` ON `adresse`.`PLZ` = `plz`.`PLZ`;";
                $result = $db->execute_query($query);
                $new_adresse = true;

                foreach ($result as $row) {
                    echo("</br>");
                    print_r($row);
                    echo("</br>");
                    print_r($_POST);   
                    if ($row["Straße"] == $_POST["Straße"] && $row["Hausnummer"] == $_POST["Hausnummer"] && $row["PLZ"] == $_POST["PLZ"] && $row["Ort"] == $_POST["Ort"]) {
                        echo ("Adresse exestiert bereits");
                        exit;
                    }

                    if ($row["PLZ"] == $_POST["PLZ"]){
                        if ($row["Ort"] == $_POST["Ort"]){
                            $new_adresse = false;
                        }
                        else{
                            echo ("Ort und PLZ stimmen nicht überein");
                            exit;
                        }
                    }
                }
                
                #Neuer Ort falls keiner vorhanden
                if ($new_adresse){
                    $query = sprintf("INSERT INTO `plz` (`PLZ`, `Ort`) VALUES ('%s', '%s') ", $_POST["PLZ"], $_POST["Ort"]);

                    if ($db->execute_query($query) === true) {
                        echo ("PLZ success");
                    }
                    else {
                        echo (mysqli::error);
                    }
                }
                print_r($_POST);
                
                #adresse hinzufügen
                $query = sprintf ("INSERT INTO `adresse` (`Adress_ID`, `Straße`, `Hausnummer`, `PLZ`) 
                                    VALUES (NULL, '%s', '%s', '%s') ", $_POST["Straße"], $_POST["Hausnummer"], $_POST["PLZ"]); 

                if ($db->execute_query($query) === true) {
                    echo ("Adrese success");
                    $_POST = array();
                }
                else {
                    echo (mysqli::error);
                }
            }

        ?>
    </body>
</html>