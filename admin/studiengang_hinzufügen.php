<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Studiengang hinzufügen</title>
    </head>
    <body>
        <?php
            #Setup
            session_start();
            $db = new mysqli('localhost', 'root', '', 'uni');
            
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
        <h1>Studiengang hinzufügen:</h1>

        <form method="post" action="">
            Bezeichnung: <input type="text" name="Bezeichnung" required /></br>
            <input type="submit" name="submit" value="hinzufügen" required />
        </form>
        <?php
            if (isset($_POST["submit"])){
                $query = "SELECT * FROM studiengang";
                $result = $db->execute_query($query);

                foreach ($result as $row) {
                    if ($row["Bezeichnung"] == $_POST["Bezeichnung"]) {
                        echo ("Studiengang exestiert bereits");
                        exit;
                    }
                }

                $query = sprintf ("INSERT INTO `studiengang` (`Studi_ID`, `Bezeichnung`) 
                VALUES (Null, '%s') ", $_POST["Bezeichnung"]); 

                    if ($db->execute_query($query) === true) {
                        echo ("success");
                        $_POST = array();
                    }
                    else {
                        echo ($db->error);
                    }
            }
        ?>
    </body>
</html>