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


function validateForm() {
    var everythingOk = true;
    everythingOk &= validateAmount();

    if (!everythingOk)
    {
        $('#save').attr('disabled', 'true');
        $('#saveAndNew').attr('disabled', 'true');
    }
    else {
        $('#save').removeAttr('disabled');
        $('#saveAndNew').removeAttr('disabled');
    }
}

$(document).ready(function() {
    validateForm();
    $('#amount').change(validateForm);
    $('#amount').on('input', validateForm);

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

