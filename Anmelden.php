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
            echo ('
            <form method="post" action="">    
                <input type="submit" name="Abmelden" value="Abmelden"/>
            </from>');
            echo ('<a href="/homepage.php">Homepage</a>');
            exit;
        }
    }   
    ?>