{include file='header.tpl'}
<ul>
    {if $entryCount > 0}
        <li>Gesamtausgaben: {$amountSum|string_format:"%.2f"} &euro;</li>
        <li>Durschnitt ohne 'Gemeinschaft': {$averageExpensesPerRealUser|string_format:"%.2f"} &euro;</li>
        <li>Ausgaben nach Benutzer:
            <ul>
                {foreach $users as $user}
                    {$expenses = $userToExpenses[$user->getId()]}
                    <li> 
                        {$user->getName()}: {$expenses|string_format:"%.2f"} &euro;
                        {if $user->isReal()}
                            (Differenz zum Durchschnitt: 
                            {($averageExpensesPerRealUser - $expenses)|string_format:"%.2f"} &euro;)
                        {/if}
                    </li>
                {/foreach}
            </ul>
        </li>
    {/if}
</ul>
<br style="clear:both"/>
{if $entryCount == 0}
    Keine Einträge für {$month} {$year}
{else}
    {$entryCount} Einträge für {$month} {$year}: 
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
{/if}
<a href="./viewbook.php?book={$book->getId()}">Zurück zur Übersicht</a>
{include file='footer.tpl'}