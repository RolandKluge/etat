{include file='header.tpl'}

<h2>Daten des Buchs eingeben</h2>
<form id="editBookForm" method="get" action="editbook.php">
    <label for="name">Name</label>
    <input name="name" type="text" size="30" value='{$name}'/>
    <br/>
    <label for="description">Beschreibung</label>
    <input name="description" type="text" size="50" value='{$description}'/>
    <br/>
    <label for="users">Benutzer:</label>
    <select name="users" multiple="">
        {foreach $users as $user}
            {if $user->isReal()}
                <option value="{$user->getId()}" 
                        {if in_array($user, $bookUsers)}selected=""{/if}
                        >{$user->getName()}</option>
            {/if}
        {/foreach}
    </select>
    <br/>
    <input name="book" type="hidden" value="{$id}"></input>
    <input name="action" type="hidden" value="{$submitAction}"></input>
    <button class="btn btnSuccess" id="save" type="submit">Speichern</button>
</form>


{if $currentAction === 'edit'}
    <h2>Buch löschen</h2>
    <div class='drop'>
        <form id='dropBookForm' method="get" action="editbook.php"
              onsubmit="return confirm('Soll dieses Buch wirklich gelöscht werden?');">
            <input name='action' type='hidden' value='drop'/>
            <input name='book' type='hidden' value='{$id}'/>
            <input class="btn btnDanger" type='submit' value='Buch löschen'/>
        </form>
    </div>
{/if}
{include file='footer.tpl'}