{include file='header.tpl'}
<h1>{$title}</h1>
<h2>Bücher</h2>
<ul id="booksList">
    {foreach $books as $book}
        <li>
            <div class="book">
                <a href="./viewbook.php?book={$book->getId()}">
                    <div>
                        <img src="static/images/book.png" width="48" height="48"/>
                    </div>
                    <div>
                        <div class="bookName">{$book->getName()}</div>
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
<hr/>
<h2>Benutzer</h2>
<ul id='usersList'>
    {foreach $users as $user}
        <li>
            <div class="user">
                <div>
                    <img src="static/images/user.png" width="48" height="48"/>
                </div>
                <div>
                    <div class="userName">{$user->getName()}</div>
                </div>
                <br/>
                <div class='drop'>
                    <a href="./edituser.php?action=drop&id={$user->getId()}">Löschen</a>
                </div>
                <div class='edit'>
                    <a href="./edituser.php?action=edit&id={$user->getId()}">Bearbeiten</a>
                </div>
            </div>
        </li>   
    {/foreach}
    <li>
        <div class="user">
            <a href="./edituser.php?action=new">
                <div>
                    <img src="static/images/user_new.png" width="48" height="48"/>
                </div>
                <div class="userName">Neuen Benutzer anlegen...</div>
            </a>
        </div>
    </li>
</ul>
{include file='footer.tpl'}