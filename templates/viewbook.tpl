{include file='header.tpl'}
<a href="./index.php">{$homeLinkLabel}</a>
<h1>{$title}</h1>
<a href="./editentry.php?action=new&bookId={$book->getId()}">Eintrag hinzufügen...</a>
<table id="entriesList">
    <thead>
    <td>Datum</td>
    <td>Betrag</td>
    <td>Beschreibung</td>
    <td>Benutzer</td>
    </thead>
    {foreach $entries as $entry}
        <tr>
            <td>{$entry->getDate()}</td>
            <td>{$entry->getAmount()}</td>
            <td>{$entry->getDescription()}</td>
            <td>{$entry->getUser()->getName()}</td>
            <td>
                <a href="./editentry.php?action=edit&id={$entry->getId()}">Bearbeiten</a>
                <a href="./editentry.php?action=drop&id={$entry->getId()}">Löschen</a>
            </td>
        <tr>
        {/foreach}
</table>
{include file='footer.tpl'}