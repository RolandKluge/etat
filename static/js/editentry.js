/*
 * Author: Roland Kluge
 */

function validateAmount() {
    var value = document.forms['editEntryForm']['amount'].value;

    if (!value.match('^\\d+(\.\\d\\d)?$'))
    {
        $('#amountNote').text('Der Betrag muss eine Dezimalzahl sein!');
        $('#submit').attr('disabled', 'true');
    }
    else {
        $('#amountNote').text('');
        $('#submit').removeAttr('disabled');
    }
}

$(document).ready(function() {
    validateAmount();
    $('#amount').change(validateAmount);
});

