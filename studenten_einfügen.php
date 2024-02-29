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
        </br>
        <form method="post" action="">
            Name: <input type="text" name="name"/></br>
            Vorname: <input type="password" name="vorname"/></br>
            Geburtsdatum: <input type="date" name="geburtstag"/></br>
            <input type="radio" name="geschlecht" value="mänlich">
            Mänlich<br>
            <input type="radio" name="geschlecht" value="weiblich">
            Weiblich<br>
            Konfession: <input type="text" name="konfession"/></br>
            Staatsangehörigkeit: <input type="text" name="staatsangehörigkeit"/></br>
            Studiengänge:</br>
            <?php
                $query = "SELECT * FROM `studiengang`";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    echo ('<input type="radio" name="studiengang" value="'.$row["Bezeichnung"].'">
                    '.$row["Bezeichnung"].'<br>');
                }

            ?>
            <input type="submit" name="submit" value="Login"/>
        </form>

        <?php
            $querry = sprintf("INSERT INTO `student` (`Matrikelnummer`, `Name`, `Vorname`, `Geburtsdatum`, `Geschlecht`, `Konfession`, `Staatsangehörigkeit`, `Studi_ID`, `Adress_ID`)
            VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s') ", "2", "3", "4", "5", "6", "7", "8", "9");
            #muss noch Form erstellen und benutzer id klären
        ?>
    </body>
</html>