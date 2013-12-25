{include file='header.tpl'}
<div class="homeLink">
    <a href="./index.php">{$homeLinkLabel}</a>
</div>
<h1>{$title}</h1>
<a href="./editentry.php?action=new&bookId={$book->getId()}">
    <div id="newEntry">
        <div id="icon"><img src="static/images/entry_new.png" width="48" height="48"/></div>
        <div id="text">Eintrag hinzufügen...</div>
    </div>
</a>
<br style="clear:both"/>
<table id="entriesList">
    <thead>
    <td>Datum</td>
    <td>Betrag</td>
    <td>Beschreibung</td>
    <td>Benutzer</td>
</thead>
{foreach $entries as $entry}
    <tr>
        <td><div class="entryDate">{$entry->getFormattedDate()}</div></td>
        <td><div class="entryAmount">{$entry->getAmount()}&euro;</div></td>
        <td><div class="entryDescription">{$entry->getDescription()}</div></td>
        <td><div class="entryUserName">{$entry->getUser()->getName()}</div></td>
        <td>
            <a href="./editentry.php?action=edit&id={$entry->getId()}">Bearbeiten</a>
            <a href="./editentry.php?action=drop&id={$entry->getId()}">Löschen</a>
        </td>
    <tr>
    {/foreach}
</table>
{include file='footer.tpl'}