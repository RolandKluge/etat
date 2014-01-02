<?php
include_once('../config/configure.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    </head>
    <body>
        <h1>Datensicherung</h1>
        <br>
        <?php
        /* database, server, user information */
        $db_host = DB_HOST;        // Name des Datenbankhost
        $db_sock = DB_SOCKET;      // Socket
        $db_user = DB_USER;        // Datenbank Benutzern Name
        $db_pass = DB_PASSWORD;    // Datenbank Passwort
        $db_name = DB_NAME;        // Datenbank Namen
        $date = date("ymd") . "-" . date("His");        // Erzeugung des Datum/Uhrzeit-Strings
        $file_name = $db_name . "_" . $date . ".sql.gz";  // Erzeugung des Namens für das Backupfile
        $path = FS_ROOT . "/backups/";   // absoluten Pfad zur Datei ermitteln

        /* zur Kontrolle die wichtigsten Variablen ausgeben */
        echo "Datum: $date";
        echo "<br><br>";
        echo "Systembenutzer: ";
        echo exec('whoami');
        echo "<br><br>";

        echo "Datenbank-Server: $db_host<br><br>";
        echo "Datenbank-Socket: $db_sock<br><br>";
        echo "Datenbank-Benutzer: $db_user<br><br>";
        echo "Path: $path<br><br>";
        echo "Filename: $file_name<br><br>";
        echo "Starte Backup<br><br>";

        if (define(DB_SOCKET)) {
            system(sprintf(
                            'mysqldump --opt -S%s -h%s -u%s -p"%s" %s | gzip  > %s/%s', DB_SOCKET, $db_host, $db_user, $db_pass, $db_name, $path, $file_name
            ));
        } else {
            system(sprintf(
                            'mysqldump --opt -h%s -u%s -p"%s" %s | gzip  > %s/%s', $db_host, $db_user, $db_pass, $db_name, $path, $file_name
            ));
        }

        echo "Backup fertig<br><br>";
        echo 'Ende';
        ?>
    </body>
</html>
