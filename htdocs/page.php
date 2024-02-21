<html>
    <head>
        <title> Kalender </title>
    </head>
    <body>
        <h1><Center>Hallo
        <?php
            session_start();
            $row=$_SESSION['row'];
            if ($row["Roll_ID"] == "3"){
                echo ("Admin"."</Center></h1>");
            }
            else{
                echo ($row['Benutzername']."</Center></h1>");
            }
            foreach($row as $item){
                echo ($item."</br>");
            }   
            
        ?>    
    </body>
</html>