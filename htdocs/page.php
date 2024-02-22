<html>
    <head>
        <title> Kalender </title>
        <link rel=“stylesheet“ href=“css/page.css“>
    </head>
    <body>
        <?php
            session_start();
            $session_row=$_SESSION['benutzer'];
            $db = new mysqli('localhost', 'root', '', 'uni');

            if ($_SESSION['login'] == false){
                header("Location: index.php");
                exit;
            }

            echo ("<h1><Center>Hallo ");
            #Rollen auswahl
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
                    
                    $_SESSION['benutzer']=$row;
                    
                    if ($row['Roll_ID'] != "3"){
                        echo ($row['Name']."</Center></h1>");
                    }   
                }
                print_r($row);
            }

            #Abmelden Knopf
            if (isset($_POST["Abmelden"])){
                $_SESSION['login'] = false;
                $_SESSION['benutzer'] = array();
                header("Location: index.php");
                exit;
            }


        ?>
        <form method="post" action="">    
            <input type="submit" name="Abmelden" value="Abmelden"/>
        </from>
        <div class="events">
            <?php
                $query= 
                    "SELECT `student`.`Matrikelnummer`, `student_konver`.`Note`, `konkrete_veranstaltung`.`Datum`, `veranstaltung`.*, `dozent`.`Name`
                    FROM `student` 
                        LEFT JOIN `student_konver` ON `student_konver`.`Matrikelnummer` = `student`.`Matrikelnummer` 
                        LEFT JOIN `konkrete_veranstaltung` ON `student_konver`.`KonVer_ID` = `konkrete_veranstaltung`.`KonVer_ID` 
                        LEFT JOIN `veranstaltung` ON `konkrete_veranstaltung`.`Veranstaltungs_ID` = `veranstaltung`.`Veranstaltungs_ID` 
                        LEFT JOIN `dozent` ON `konkrete_veranstaltung`.`Dozi_ID` = `dozent`.`Dozi_ID`;";
                
                $result = $db->execute_query($query);
                foreach ($result as $row){
                    #print_r($row);
                    echo ("</br>");
                    foreach($row as $key => $val){
                        echo "$key:    $val <br/>";
                    }

                }
            ?>
        </div>

        <div class="calendar">
  <div class="timeline">
    <div class="spacer"></div>
    <div class="time-marker">9 AM</div>
    <div class="time-marker">10 AM</div>
    <div class="time-marker">11 AM</div>
    <div class="time-marker">12 PM</div>
    <div class="time-marker">1 PM</div>
    <div class="time-marker">2 PM</div>
    <div class="time-marker">3 PM</div>
    <div class="time-marker">4 PM</div>
    <div class="time-marker">5 PM</div>
    <div class="time-marker">6 PM</div>
  </div>
  <div class="days">
    <div class="day mon">
      <div class="date">
        <p class="date-num">9</p>
        <p class="date-day">Mon</p>
      </div>
      <div class="events">
        <div class="event start-2 end-5 securities">
          <p class="title">Securities Regulation</p>
          <p class="time">2 PM - 5 PM</p>
        </div>
      </div>
    </div>
    <div class="day tues">
      <div class="date">
        <p class="date-num">12</p>
        <p class="date-day">Tues</p>
      </div>
      <div class="events">
        <div class="event start-10 end-12 corp-fi">
          <p class="title">Corporate Finance</p>
          <p class="time">10 AM - 12 PM</p>
        </div>
        <div class="event start-1 end-4 ent-law">
          <p class="title">Entertainment Law</p>
          <p class="time">1PM - 4PM</p>
        </div>
      </div>
    </div>
    <div class="day wed">
      <div class="date">
        <p class="date-num">11</p>
        <p class="date-day">Wed</p>
      </div>
      <div class="events">
        <div class="event start-12 end-1 writing">
          <p class="title">Writing Seminar</p>
          <p class="time">11 AM - 12 PM</p>
        </div>
        <div class="event start-2 end-5 securities">
          <p class="title">Securities Regulation</p>
          <p class="time">2 PM - 5 PM</p>
        </div>
      </div>
    </div>
    <div class="day thurs">
      <div class="date">
        <p class="date-num">12</p>
        <p class="date-day">Thurs</p>
      </div>
      <div class="events">
        <div class="event start-10 end-12 corp-fi">
          <p class="title">Corporate Finance</p>
          <p class="time">10 AM - 12 PM</p>
        </div>
        <div class="event start-1 end-4 ent-law">
          <p class="title">Entertainment Law</p>
          <p class="time">1PM - 4PM</p>
        </div>
      </div>
    </div>
    <div class="day fri">
      <div class="date">
        <p class="date-num">13</p>
        <p class="date-day">Fri</p>
      </div>
      <div class="events">
      </div>
    </div>
  </div>
</div>
    </body>
</html>