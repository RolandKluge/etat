{include file='header.tpl'}
<a href="./editentry.php?action=new&bookId={$book->getId()}">
    <div id="newEntry">
        <div id="icon"><img src="static/images/entry_new.png" width="48" height="48"/></div>
        <div id="text">Eintrag hinzufügen...</div>
    </div>
</a>
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
            <a href="./editentry.php?action=edit&id={$entry->getId()}">Bearbeiten</a>
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