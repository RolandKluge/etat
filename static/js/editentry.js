/*
 * Author: Roland Kluge
 */

function validateAmount() {
    var value = document.forms['editEntryForm']['amount'].value;

    if (!value.match('^\\d+(\.\\d\\d?)?$'))
    {
        $('#amountNote').text('Der Betrag muss eine Dezimalzahl sein!');
        return false;
    }
    else {
        $('#amountNote').text('');
        return true;
    }
}

function validateDate() {
    var value = document.forms['editEntryForm']['date'].value;

    if (!value.match('^\\d\\d\.\\d\\d.\\d\\d\\d\\d$'))
    {
        $('#dateNote').text('Das Datum in folgendem Format eingeben: 01.04.2013');
        return false;
    }
    else {
        $('#dateNote').text('');
        return true;
    }
}

function validateForm() {
    var everythingOk = true;
    everythingOk &= validateAmount();
    everythingOk &= validateDate();

    if (!everythingOk)
    {
        $('#save').attr('disabled', 'true');
    }
    else {
        $('#save').removeAttr('disabled');
    }
}

$(document).ready(function() {
    validateForm();
    $('#amount, #date').change(validateForm);
    $('#amount, #date').on('input', validateForm);
    $('#date').datepicker({dateFormat: "dd.mm.yy", 
        showOn: "button",
        buttonImage: "./static/images/calendar.gif",
        buttonImageOnly: true
    });
    $('.descriptionSuggestion').click(function() {
        $('#description').attr('value', $(this).text());
    });
    
});

