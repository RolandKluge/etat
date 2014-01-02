{include file='header.tpl'}
<ul>
    <li>Einträge in diesem Monat: {$entryCount}</li>
    <li>Gesamtausgaben: {$amountSum|string_format:"%.2f"} &euro;</li>
    <li>Durschnitt über Benutzer: {$averageExpensesPerUser} &euro;</li>
    <li>Ausgaben nach Benutzer:
        <ul>
            {foreach $users as $user}
                {$expenses = $userToExpenses[$user->getId()]}
                <li> 
                    {$user->getName()}: {$expenses|string_format:"%.2f"} &euro; 
                    (Differenz zum Durchschnitt: 
                    {$averageExpensesPerUser - $expenses|string_format:"%.2f"})
                </li>
            {/foreach}
        </ul>
    </li>
</ul>
{include file='footer.tpl'}