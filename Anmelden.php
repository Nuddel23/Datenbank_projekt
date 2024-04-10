<?php
    #Abmelden Knopf
    if (isset($_POST["Abmelden"])){
        $_SESSION['login'] = false;
    }
            
    #Abmelden
    if ($_SESSION['login'] == false){
        $_SESSION = array();
        header("Location: /index.php");
        exit;
    }

    #nur Admin
    if($AdminOnly){
        if ($_SESSION["Roll_ID"] != 3){
            echo ("<h1><Center>Du bist kein Admin</Center></h1>");
            echo ('<a href="/homepage.php">Homepage</a>');
            exit;
        }
    }    
    ?>