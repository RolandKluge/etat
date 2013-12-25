{include file='header.tpl'}
<script src="static/js/editentry.js"></script>
<div class="homeLink">
    <a href="./index.php">Home</a>
</div>
<h1>{$title}</h1>
<form id="editEntryForm" method="get" action="editentry.php">
    <label for="amount">Betrag:</label>
    <input id="amount" name="amount" type="text" size="4" value='{$amount}'/>Euro
    <span id="amountNote" class="errorMessage"></span>
    <br/>
    <label for="date">Datum:</label>
    <input name="date" type="text" size="10" value='{$date}'/>
    <br/>
    <label for="description">Beschreibung</label>
    <input name="description" type="text" size="50" value='{$description}'/>
    <br/>
    <label for="users">Benutzer:</label>
    <select name="user" >
        {foreach $users as $u}
            <option value="{$u->getId()}"
                {if $user === $u}selected=""{/if}
                >{$u->getName()}</option>
        {/foreach}
    </select>
    <br/>
    <input name="id" type="hidden" value="{$id}"></input>
    <input name="book" type="hidden" value="{$book->getId()}"></input>
    <input name="action" type="hidden" value="{$action}"></input>
    <button id="submit" type="submit">Speichern</button>
</form>
{include file='footer.tpl'}