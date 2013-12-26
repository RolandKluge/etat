{include file='header.tpl'}
<form id="editUserForm" method="get" action="edituser.php">
    <label for="name">Name</label>
    <input name="name" type="text" size="30" value='{$name}'/>
    <br/>
    <input name="id" type="hidden" value="{$id}"></input>
    <input name="action" type="hidden" value="{$action}"></input>
    <button id="save" type="submit">Speichern</button>
</form>
{include file='footer.tpl'}