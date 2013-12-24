{include file='header.tpl'}
<h1>{$title}</h1>
<ul id="booksList">
    {foreach $books as $book}
        <li>
            <div class="book">
                <a href="./viewbook.php?book={$book->getId()}">
                    <div>
                        <img src="static/images/book.png" width="48" height="48"/>
                    </div>
                    <div>
                        <div class="bookId">{$book->getId()}</div>:<div class="bookName">{$book->getName()}</div>
                    </div>
                </a>
                <br/>
                <div class='bookDescription'>{$book->getDescription()}</div>
                <div class='drop'>
                    <a href="./editbook.php?action=drop&id={$book->getId()}">Löschen</a>
                </div>
                <div class='edit'>
                    <a href="./editbook.php?action=edit&id={$book->getId()}">Bearbeiten</a>
                </div>
            </div>
        </li>
    {/foreach}
    <li>
        <div class="book">
            <a href="./editbook.php?action=new">
                <div>
                    <img src="static/images/book_new.png" width="48" height="48"/>
                </div>
                <div class="bookName">Neues Buch anlegen...</div>
            </a>
        </div>
    </li>
</ul>
{include file='footer.tpl'}