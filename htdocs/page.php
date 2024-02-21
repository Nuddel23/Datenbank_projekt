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

            switch($session_row['Roll_ID']){
                case 1:      
                    $query = 
                        "SELECT `student`.*, `benutzer`.*
                        FROM `student` 
                        LEFT JOIN `benutzer` ON `student`.`ben_ID` = `benutzer`.`ID`;";
                    break;
                case 2:
                    $query = 
                        "SELECT `dozent`.*, `benutzer`.*
                        FROM `dozent` 
                        LEFT JOIN `benutzer` ON `dozent`.`ben_ID` = `benutzer`.`ID`;";
                    break;
                case 3:
                    $query=
                        "SELECT `benutzer`.*
                        FROM `benutzer`;";
                    echo ("Admin"."</Center></h1>");
                    break;
            }
            $result = $db->execute_query($query);
            
            foreach($result as $row){
                if ($row['ID'] == $session_row['ID']){
                    
                    #$_SESSION['row']=$row;
                    
                    if ($row['Roll_ID'] != "3"){
                        echo ($row['Name']."</Center></h1>");
                    }   
                }
                print_r($row);
            }
        ?>    
    </body>
</html>