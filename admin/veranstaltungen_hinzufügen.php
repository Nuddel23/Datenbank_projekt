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
    </body>
</html>