{include file='header.tpl'}
<ul>
    <li>Einträge in diesem Monat: {$entryCount}</li>
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
    <a href="./viewbook.php?book={$book->getId()}">Zurück zur Übersicht</a>
</ul>
{include file='footer.tpl'}