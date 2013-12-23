<html>
    <head>
        <meta charset="UTF-8">
        <title>{$title}</title>
        <link rel="stylesheet" href="static/css/stylesheet.css">
    </head>
    <body>
        <h1>{$title}</h1>
        <ul id="booksList">
            {foreach $books as $book}
                <li>
                    <a href="./viewbook.php?book=<?php echo $name ?>">
                        <img src="static/images/book.png" width="48" height="48"/>
                        <div class="bookId">{$book->getId()}</div>:<div class="bookName">{$book->getName()}</div>
                    </a>
                </li>
            {/foreach}
            <li>
                <a href="./editbook.php?action=new">
                    <img src="static/images/book_new.png" width="48" height="48"/>
                    <div class="bookName">Neues Buch anlegen...</div>
                </a>
            </li>
        </ul>
    </body>
</html>
