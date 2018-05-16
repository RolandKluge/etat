{include file='header.tpl'}
<a href="./editentry.php?action=new&book={$book->getId()}">
    <div id="newEntry">
        <div id="icon"><img src="static/images/entry_new.png" width="48" height="48"/></div>
        <div id="text">Eintrag hinzufügen...</div>
    </div>
</a>
<br style="clear:both"/>
<div id="monthlyBalance">
    <div><strong>Statistik:</strong></div>
    <form method="get" action="./monthlyBalance.php">
        <select name="month">
            {foreach from=$months key=monthId item=month}
                <option value="{$monthId}"
                        {if $monthId == $suggestedMonth}
                            selected
                        {/if}
                        >{$month}</option>
            {/foreach}
        </select>
        <select name="year">
            {foreach $years as $year}
                <option value="{$year}"
                        {if $year == $suggestedYear}
                            selected
                        {/if}
                        >{$year}</option>
            {/foreach}
        </select>
        <input name="book" type="hidden" value="{$book->getId()}"/>
        <input type="submit" value="Monatsstatistik"></input>
    </form>
    <form method="get" action="./yearlyBalance.php">
        <select name="year">
            {foreach $years as $year}
                <option value="{$year}"
                        {if $year == $suggestedYear}
                            selected
                        {/if}
                        >{$year}</option>
            {/foreach}
        </select>
        <input name="book" type="hidden" value="{$book->getId()}"/>
        <input type="submit" value="Jahresstatistik"></input>
    </form>
</div>
<br style="clear:both"/>

<div class="entryNavigation">
{if $limitFrom > 1}
    {$prevLimitFrom = max($limitFrom - $visibleEntryCount, 1)}
    {$prevLimitTo = $limitFrom - 1}
    {$prevEntryCount = $prevLimitTo - $prevLimitFrom + 1}
    <a href="./viewbook.php?book={$book->getId()}&limitFrom={$prevLimitFrom}&limitTo={$prevLimitTo}">&lt;&lt;</a><!--Zeige vorige {$prevEntryCount} Einträge-->
{/if}
{$entryCount} Einträge &mdash; Zeige Einträge {$limitFrom} bis {$limitTo}
{if $limitTo < $entryCount}
    {$nextLimitFrom = $limitTo + 1}
    {$nextLimitTo = min($nextLimitFrom + $visibleEntryCount - 1, $entryCount)}
    {$nextEntryCount = $nextLimitTo - $nextLimitFrom + 1}
    <a href="./viewbook.php?book={$book->getId()}&limitFrom={$nextLimitFrom}&limitTo={$nextLimitTo}">&gt;&gt;</a><!--Zeige nächste {$nextEntryCount} Einträge-->
{/if}
</div>

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

<div class="entryNavigation">
{if $limitFrom > 1}
    {$prevLimitFrom = max($limitFrom - $visibleEntryCount, 1)}
    {$prevLimitTo = $limitFrom - 1}
    {$prevEntryCount = $prevLimitTo - $prevLimitFrom + 1}
    <a href="./viewbook.php?book={$book->getId()}&limitFrom={$prevLimitFrom}&limitTo={$prevLimitTo}">&lt;&lt;</a><!--Zeige vorige {$prevEntryCount} Einträge-->
{/if}
{$entryCount} Einträge - Zeige: {$limitFrom} bis {$limitTo}
{if $limitTo < $entryCount}
    {$nextLimitFrom = $limitTo + 1}
    {$nextLimitTo = min($nextLimitFrom + $visibleEntryCount - 1, $entryCount)}
    {$nextEntryCount = $nextLimitTo - $nextLimitFrom + 1}
    <a href="./viewbook.php?book={$book->getId()}&limitFrom={$nextLimitFrom}&limitTo={$nextLimitTo}">&gt;&gt;</a><!--Zeige nächste {$nextEntryCount} Einträge-->
{/if}
</div>

{include file='footer.tpl'}
