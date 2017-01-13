{include file='header.tpl'}
<h2>Benutzerdaten eingeben</h2>
<form id="editUserForm" method="get" action="edituser.php">
    <label for="books">Bücher</label>
    <input name="books" type="text" size="30" readonly="true" value='{foreach $userBooks as $book}{$book->getName()}{if !$book@last},{/if}{foreachelse}Keine Bücher.{/foreach}
    '/>
    <label for="name">Name</label>
    <input name="name" type="text" size="30" value='{$name}'/>
    <br/>
    <input name='user' type="hidden" value="{$id}"></input>
    <input name="action" type="hidden" value="{$submitAction}"></input>
    <button class="btn btnSuccess" id="save" type="submit">Speichern</button>
</form>

{if $currentAction === 'edit'}
<h2>Benutzer löschen</h2>
    <div class='drop'>
        <form id='dropUserForm' method="get" action="edituser.php"
              onsubmit="return confirm('Soll dieser Benutzer wirklich gelöscht werden?');">
            <input name='action' type='hidden' value='drop'/>
            <input name='user' type='hidden' value='{$id}'/>
            <input class="btn btnDanger" type='submit' value='Benutzer löschen'/>
        </form>
    </div>
{/if}
{include file='footer.tpl'}