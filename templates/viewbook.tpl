{include file='header.tpl'}
<a href="./editentry.php?action=new&book={$book->getId()}">
    <div id="newEntry">
        <div id="icon"><img src="static/images/entry_new.png" width="48" height="48"/></div>
        <div id="text">Eintrag hinzufügen...</div>
    </div>
</a>
<img src="static/images/sigma_upper.png" width="48" height="48"/>
<form method="get" action="./monthlyBalance.php">
    <input type="submit" value="Monatsstatistik"></input>
    <select name="month"><option value="1">Januar</option></select>
    <select name="year"><option value="2014">2014</option></select>
    <input name="book" type="hidden" value="{$book->getId()}"/>
</form>
<br style="clear:both"/>
Einträge: {$entryCount} - Zeige: {$limitFrom} bis {$limitTo}
<table id="entriesList">
    <col width='15%'>
    <col width='15%'>
    <col width='40%'>
    <col width='15%'>
    <col width='15%'>
    <thead>
    <td>Datum</td>
    <td>Betrag</td>
    <td>Beschreibung</td>
    <td>Benutzer</td>
    <td></td>
</thead>
{foreach $entries as $entry}
    <tr>
        <td><div class="entryDate">{$entry->getFormattedDate()}</div></td>
        <td><div class="entryAmount">{$entry->getAmount()}&euro;</div></td>
        <td><div class="entryDescription">{$entry->getDescription()}</div></td>
        <td><div class="entryUserName">{$entry->getUser()->getName()}</div></td>
        <td>
            <a href="./editentry.php?action=edit&entry={$entry->getId()}">Bearbeiten</a>
        </td>
    <tr>
    {/foreach}
</table>
{if $limitFrom > 1}
    {$prevLimitFrom = max($limitFrom - $visibleEntryCount, 1)}
    {$prevLimitTo = $limitFrom - 1}
    {$prevEntryCount = $prevLimitTo - $prevLimitFrom}
    <a href="./viewbook.php?id={$book->getId()}&limitFrom={$prevLimitFrom}&limitTo={$prevLimitTo}">Zeige vorige {$prevEntryCount} Einträge</a>
{/if}
{if $limitTo < $entryCount}
    {$nextLimitFrom = $limitTo + 1}
    {$nextLimitTo = min($limitTo + $visibleEntryCount, $entryCount)}
    {$nextEntryCount = $nextLimitTo - $nextLimitFrom + 1}
    <a href="./viewbook.php?id={$book->getId()}&limitFrom={$nextLimitFrom}&limitTo={$nextLimitTo}">Zeige nächste {$nextEntryCount} Einträge</a>
{/if}
{include file='footer.tpl'}