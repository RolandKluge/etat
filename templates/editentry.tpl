{include file='header.tpl'}

<script src="static/js/editentry.js"></script>
<h2>Daten des Eintrags eingeben</h2>
<form id="editEntryForm" method="get" action="editentry.php">
    <label for="bookName">Buch:</label>
    <input name="bookName" type="text" value='{$book->getName()}' readonly="true"/>

    <label for="amount">Betrag:</label>
    <input id="amount" name="amount" type="numeric" size="4" value='{$amount}'/>
    <span id='currency'>Euro</span>
    <span id="amountNote" class="errorMessage"></span>

    <label for="date">Datum:</label>
    <input id="date" name="date" type="text" size="10" value='{$date}'/>
    <input id="prevDay" type="button" value="-"/>
    <input id="nextDay" type="button" value="+"/>
    <span id="dateNote" class="errorMessage"></span>

    <label for="description">Beschreibung</label>
    <input id='description' name="description" type="text" size="50" value='{$description}'/>

    <!--
    <label>Vorschläge:</label>
    <div class='descriptionSuggestions'>
        {foreach $descriptionSuggestions as $suggestion}
            <div class='descriptionSuggestion'>{$suggestion}</div>
        {foreachelse}
            <div id='noSuggestions'>Keine Vorschläge</div>
        {/foreach}
    </div>
    -->

    <label for="user">Benutzer:</label>
    <select name="user" >
        {foreach $users as $u}
            <option value="{$u->getId()}"
                    {if $user && $user->getId() === $u->getId()}selected=""{/if}
                    >{$u->getName()}</option>
        {/foreach}
    </select>

    <input name="entry" type="hidden" value="{$id}"></input>
    <input name="book" type="hidden" value="{$book->getId()}"></input>
    <input name="action" type="hidden" value="{$submitAction}"></input>
    <!--
    The 'afterSaveAction' should be either 'overview' or 'new'.
    In case of 'overview' the next visible page should be the overview of the current book,
    in case of 'new' the next visible page should be an empty new entry.
    -->
    <input name="afterSaveAction" type="hidden" value="overview"></input>
    <input type="button" id="save" class="btnSuccess btn" value="Speichern"/>
    <input type="button" id="saveAndNew" class="btnSuccess btn" value="Speichern & Neu"/>
    <input type="button" id="abort" class="btnDanger btn" value="Abbrechen"/>
</form>

{if $currentAction === 'edit'}
    <h2>Eintrag löschen</h2>
    <div class='drop'>
        <form id='dropEntryForm' method="get" action="editentry.php" 
              onsubmit="return confirm('Soll dieser Eintrag wirklich gelöscht werden?');">
            <input name='action' type='hidden' value='drop'/>
            <input name='entry' type='hidden' value='{$id}'/>
            <input class="btnDanger btn" type='submit' value='Eintrag löschen'/>
        </form>
    </div>
{/if}

<script type="text/javascript">
    var bookId="{$book->getId()}";
</script>
{include file='footer.tpl'}
