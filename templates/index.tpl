{include file='header.tpl'}
<h2>Bücher</h2>
<div id="booksList">
    <ul >
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
                        <br/>
                        <div class='bookDescription'>{$book->getDescription()}</div>
                        <br/>
                        <div class='bookUsers'>
                            Benutzer:
                            <span class='bookUserName'>
                                {foreach $bookToUsers[$book->getId()] as $user}
                                    {$user->getName()}{if !$user@last},{/if}
                                {foreachelse}
                                    Keine Benutzer.
                                {/foreach}
                            </span>
                        </div>
                    </a>
                    <div class='edit'>
                        <a href="./editbook.php?action=edit&book={$book->getId()}">Bearbeiten</a>
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
</div>
<h2>Benutzer</h2>
<div id='usersList'>
    <ul >
        {foreach $users as $user}
            {if $user->isReal()}
                <li>
                    <div class="user">
                        <div>
                            <img src="static/images/user.png" width="48" height="48"/>
                        </div>
                        <div>
                            <div class="userName">{$user->getName()}</div>
                        </div>
                        <br/>
                        <div class='edit'>
                            <a href="./edituser.php?action=edit&user={$user->getId()}">Bearbeiten</a>
                        </div>
                    </div>
                </li>   
            {/if}
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
</div>
<h2>Verwaltung</h2>
<div id='backup'>
    <a href="./backup.php">
        Backup durchführen
    </a>
</div>
{include file='footer.tpl'}