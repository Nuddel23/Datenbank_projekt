<html>
    <head>
        <title> Kalender </title>
    </head>
    <body>
        <h1>Kalender</h1>
        <?php
            $db = new mysqli('localhost', 'root', '', 'uni');    
                
            $query = "SELECT * FROM benutzer";
            $result = $db->execute_query($query);

            if(mysqli_num_rows($result) > 0)
            {
            $table = '
                <table border=1>
                    <tr>
                        <th>Person ID</th>
                        <th>Name</th>
                        <th>Passwort</th>
                        <th>Rolle</th>
                    </tr>
            ';
            while($row = mysqli_fetch_array($result))
            {
            $table .= '
                <tr>
                    <td>'.$row["ID"].'</td>
                    <td>'.$row["Benutzername"].'</td>
                    <td>'.$row["Passwort"].'</td>
                    <td>'.$row["Roll_ID"].'</td>
                </tr>
            ';
            }
            $table .= '</table>';
            echo $table;
            }
    ?>
        
    </body>
</html>