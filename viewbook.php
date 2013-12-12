<!DOCTYPE html>
<!--
 - 
 -  Author: Roland Kluge
-->
<?php
include('config/configure.php');

$bookName = $_GET["book"];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Entries in <?php echo $bookName?></title>
    </head>
    <body>
        <a href="./index.php">Back to Overview</a>
        <h2>Entries in <?php echo $bookName?></h2>
    </body>
</html>
