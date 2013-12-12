<!DOCTYPE html>
<!--
 - 
 -  Author: Roland Kluge
-->
<?php
include('config/configure.php');
include('dao/BookDao.php');

$bookDao = new BookDao();
$books = $bookDao->getAll();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Overview of Books</title>
    </head>
    <body>
        <h2>Books</h2>
        <ul>
            <?php
            foreach ($books as $book) {
                $name = $book->getName();
                ?>
                <li>
                    <a href="./viewbook.php?book=<?php echo $name ?>">
                        <?php echo $book->getId() . ": " . $book->getName() ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </body>
</html>
