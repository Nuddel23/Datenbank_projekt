<html>
    <head>
        <title> Kalender </title>
    </head>
    <body>
        <h1><Center>Hallo
        <?php
            session_start();
            $session_row=$_SESSION['row'];

            $db = new mysqli('localhost', 'root', '', 'uni');              
            $query = 
                "SELECT `student`.*, `benutzer`.*
                FROM `student` 
                LEFT JOIN `benutzer` ON `student`.`ben_ID` = `benutzer`.`ID`;
                ";
            $result = $db->execute_query($query);
            
            foreach($result as $row){
                if ($row['ID'] == $session_row['ID']){
                    $_SESSION['row']=$row;
                    
                    if ($row['Roll_ID'] == "3"){
                        echo ("Admin"."</Center></h1>");
                    }
                    else{
                        echo ($row['Name']."</Center></h1>");
                    }   
                }
            }
        ?>    
    </body>
</html>