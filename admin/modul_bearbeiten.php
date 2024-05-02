<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul bearbeiten</title>
</head>

<body>
    <h1>Diese Seite war nur Idee</h1>
    <?php
    #Setup
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/Datenbank.php";

    $AdminOnly = true;
    require $_SERVER['DOCUMENT_ROOT'] . "/Anmelden.php";
    ?>
    <form method="post" action="">
        <input type="submit" name="Abmelden" value="Abmelden" />
        </from>

        <a href="/../homepage.php">Homepage</a></br>
        <h1>Modul bearbeiten:</h1>

        <!-- studiengang auswahl -->
        <form method="POST" action="">
            <?php

            if (isset($_POST["studiengang"]) == false) {
                $_POST["studiengang"] = 1;
            }

            #studiengang
            echo ("Studiengang:</br>");
            echo ('<select name="studiengang" onchange="this.form.submit()">');

            $query = "SELECT * FROM `studiengang`";
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                if ($row["Studi_ID"] == $_POST["studiengang"]) {
                    echo ('<option selected="selected" value="' . $row["Studi_ID"] . '">
                ' . $row["Bezeichnung"] . '</option>');
                } else {
                    echo ('<option value="' . $row["Studi_ID"] . '">
                ' . $row["Bezeichnung"] . '</option>');
                }
            }
            echo ("</select></br>");
            ?>
        </form>

        <!-- Daten eintragen -->
        <form method="POST" action="">
            <?php
            #alle Module werden mit radio button angezeigt
            $query = sprintf("SELECT `modul`.*, `beinhaltet`.`Semester`, `studiengang`.`Studi_ID`
                    FROM `modul` 
                    LEFT JOIN `beinhaltet` ON `beinhaltet`.`Modul_ID` = `modul`.`Modul_ID` 
                    LEFT JOIN `studiengang` ON `beinhaltet`.`Studi_ID` = `studiengang`.`Studi_ID`
                    WHERE studiengang.Studi_ID = %s;", $_POST["studiengang"]);
            $result = $db->execute_query($query);

            foreach ($result as $row) {
                echo sprintf('<input type="radio" id="%s" name="Modul" value="%s" required >
                        <label for="%s">%s</label></br>',
                    $row["Bezeichnung"],
                    $row["Modul_ID"],
                    $row["Bezeichnung"],
                    $row["Bezeichnung"] . " " . $row["Semester"]
                );
            }

            echo ('Auswhal:</br>
                <input type="radio" id="Neu" name="Auswahl" value=1 required >
                <label for="%s">Löschen</label></br>
                <input type="radio" id="Neu" name="Auswahl" value=2 required >
                <label for="%s">Bearbeiten</label></br>');


            ?>
            <input type="submit" name="submit1" value="einfügen" />
        </form>


        <!-- Daten verarbeiten -->
        <?php
        if (isset($_POST["suhjtgfizutfbmit1"])) {

        } else {

        }
        ?>
</body>

</html>