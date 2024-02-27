<html>
    <head>
        <title> Login Page </title>
    </head>
    <body>
        <h1>Login</h1>
        <?php
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $db = new mysqli('localhost', 'root', '', 'login');    
                
                $query = "SELECT * FROM accounts";
                $result = $db->execute_query($query);

                if(mysqli_num_rows($result) > 0)
                {
                 $table = '
                  <table border=1>
                                   <tr>
                                        <th> Person ID </th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>City</th>
               
                                   </tr>
                 ';
                 while($row = mysqli_fetch_array($result))
                 {
                  $table .= '
                   <tr>
                                       <td>'.$row["Benutzer_ID"].'</td>
                                        <td>'.$row["Benutzername"].'</td>
                                        <td>'.$row["Passwort"].'</td>
                                        <td>'.$row["Benutzer_ID"].'</td>
               
               
                                   </tr>
                  ';
                 }
                 $table .= '</table>';
            echo $table;
            }
        ?>
        
    </body>
</html>