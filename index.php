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
        <link rel="stylesheet" href="static/css/stylesheet.css">
    </head>
    <body>
        <h2>Books</h2>
        <ul id="booksList">
            <?php
            foreach ($books as $book) {
                $name = $book->getName();
                ?>
                <li>
                    <a href="./viewbook.php?book=<?php echo $name ?>">
                        <img src="static/images/book.png" width="48" height="48"/>
                        <div class="bookId"><?php echo $book->getId(); ?></div>:<div class="bookName"><?php echo $book->getName(); ?></div>
                    </a>
                </li>
                <?php
            }
            ?>
            <li>
                <a href="./editbook.php?action=new">
                    <img src="static/images/book_new.png" width="48" height="48"/>
                    <div class="bookName">Neues Buch anlegen...</div>
                </a>
            </li>
        </ul>
    </body>
</html>
