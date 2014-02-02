<?php
/*
 * Author: Rüdiger Kluge
 * Author: Roland Kluge
 */

include_once('config/configure.php');
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
        $db_user = DB_USER;        // Datenbank Benutzern Name
        $db_pass = DB_PASSWORD;    // Datenbank Passwort
        $db_name = DB_NAME;        // Datenbank Namen
		$db_default_charset = DB_DEFAULT_CHARSET;
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
        echo "Datenbank-Benutzer: $db_user<br><br>";
		echo "Default character set: $db_default_charset<br/><br/>";
        echo "Path: $path<br><br>";
        echo "Filename: $file_name<br><br>";
        echo "Starte Backup<br><br>";

        $exitCode = NULL;

        if (defined("DB_SOCKET")) {
            $command = sprintf(
                            'mysqldump --opt -S%s -h%s -u%s -p"%s" --default-character-set %s %s | gzip  > %s/%s', DB_SOCKET, $db_host, $db_user, $db_pass, $db_default_charset, $db_name, $path, $file_name
                    );
        } else {
            $command = sprintf(
            'mysqldump --opt -h%s -u%s -p"%s" --default-character-set %s %s | gzip  > %s/%s', $db_host, $db_user, $db_pass, $db_default_charset, $db_name, $path, $file_name);
        }
        
        #echo "Command: $command<br/><br/>";
        $errorMessage = system($command, $exitCode);

        if ($exitCode != 0) {
            $css = 'color: red;';
            $errorMessage = "ERROR: $errorMessage";
        } else {
            $css = '';
        }
        
        echo "<span style='$css'>Exit code: $exitCode $errorMessage</span><br/><br/>";

        echo "Backup fertig<br><br>";
        echo 'Ende';
        ?>
        <hr/>
        <p>
            <a href='index.php'>Home</a>
        </p>
    </body>
</html>
