{include file='header.tpl'}

<script src="static/js/editentry.js"></script>

<h2>Daten des Eintrags eingeben</h2>
<form id="editEntryForm" method="get" action="editentry.php">
    <label for="bookName">Buch:</label>
    <input name="bookName" type="text" value='{$book->getName()}' readonly="true"/>

    <label for="amount">Betrag:</label>
    <input id="amount" name="amount" type="text" size="4" value='{$amount}'/>
    <span id='currency'>Euro</span>
    <span id="amountNote" class="errorMessage"></span>

    <label for="date">Datum:</label>
    <input id="date" name="date" type="text" size="10" value='{$date}'/>
    <span id="dateNote" class="errorMessage"></span>

    <label for="description">Beschreibung</label>
    <input id='description' name="description" type="text" size="50" value='{$description}'/>

    <label>Vorschläge:</label>
    <div class='descriptionSuggestions'>
        {foreach $descriptionSuggestions as $suggestion}
            <div class='descriptionSuggestion'>{$suggestion}</div>
        {foreachelse}
            <div id='noSuggestions'>Keine Vorschläge</div>
        {/foreach}
    </div>

    <label for="user">Benutzer:</label>
    <select name="user" >
        {foreach $users as $u}
            <option value="{$u->getId()}"
                    {if $user && $user->getId() === $u->getId()}selected=""{/if}
                    >{$u->getName()}</option>
        {/foreach}
    </select>

    <input name="id" type="hidden" value="{$id}"></input>
    <input name="book" type="hidden" value="{$book->getId()}"></input>
    <input name="action" type="hidden" value="{$submitAction}"></input>
    <button id="save" id="submit" type="submit">Speichern</button>
</form>

{if $currentAction === 'edit'}
    <h2>Eintrag löschen</h2>
    <div class='drop'>
        <form id='dropEntryForm' method="get" action="editentry.php" 
              onsubmit="return confirm('Soll dieser Eintrag wirklich gelöscht werden?');">
            <input name='action' type='hidden' value='drop'/>
            <input name='id' type='hidden' value='{$id}'/>
            <input type='submit' value='Eintrag löschen'/>
        </form>
    </div>
{/if}
{include file='footer.tpl'}