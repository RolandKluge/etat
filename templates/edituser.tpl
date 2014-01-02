{include file='header.tpl'}
<h2>Benutzerdaten eingeben</h2>
<form id="editUserForm" method="get" action="edituser.php">
    <label for="name">Name</label>
    <input name="name" type="text" size="30" value='{$name}'/>
    <br/>
    <input name='user' type="hidden" value="{$id}"></input>
    <input name="action" type="hidden" value="{$submitAction}"></input>
    <button id="save" type="submit">Speichern</button>
</form>

{if $currentAction === 'edit'}
<h2>Benutzer löschen</h2>
    <div class='drop'>
        <form id='dropUserForm' method="get" action="edituser.php"
              onsubmit="return confirm('Soll dieser Benutzer wirklich gelöscht werden?');">
            <input name='action' type='hidden' value='drop'/>
            <input name='user' type='hidden' value='{$id}'/>
            <input type='submit' value='Benutzer löschen'/>
        </form>
    </div>
{/if}
{include file='footer.tpl'}