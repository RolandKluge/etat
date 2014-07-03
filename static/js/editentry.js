/*
 * Author: Roland Kluge
 */

function validateAmount() {
    var value = document.forms['editEntryForm']['amount'].value;

    if (!value.match('^\\s*[\\-]?\\d+([\.,]\\d\\d?)?\\s*$'))
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

/*
 * Parses a string of the form YY.MM.DD to a date instance
 */
function parseDate(dateString) {
    var parts = dateString.split(".");
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function formatDate(date) {
    return date.getDate() + "." + (date.getMonth() + 1) + "." + date.getFullYear()
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

    $('#prevDay').click(function() {
        var currentDate = parseDate($('#date').val())
        var prevDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() - 1);
        $('#date').val(formatDate(prevDate));
    });

    $('#nextDay').click(function() {
        var currentDate = parseDate($('#date').val())
        var nextDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + 1);
        $('#date').val(nextDate.getDate() + "." + (nextDate.getMonth() + 1) + "." + nextDate.getFullYear());
    });

    $('#save').click(function() {
        $("input[name='afterSaveAction']").val("overview");
        $(this).closest('form').submit();
    });

    $('#saveAndNew').click(function() {
        $("input[name='afterSaveAction']").val("new");
        $(this).closest('form').submit();
    });

    $('#abort').click(function() {
        window.location = "viewbook.php?book=" + bookId;
    });

});

