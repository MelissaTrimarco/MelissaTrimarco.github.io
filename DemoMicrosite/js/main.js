/* What happens when the document starts */
$(document).ready(function () {

    update();

    /* Kick off an update when the button selection changes */
    $('.radio-button').change(function () {
        update();
    });

    $('.free-input').keyup(function () {
        /* Send through the box in focus to avoid formatting it */
        update($(this).attr('id'));
    });
    $('.free-input').focusout(function () {
        update();
    });

});


function reupdate() {
    update();
}

/* Our Main Function */
function update(focus) {

    /* Grab all the variables build into the html*/

    var currency = $("#currency").html();
    var minAmount = $("#minAmount").html();
    var maxAmount = $("#maxAmount").html();

    var update = false;

    /* Check how many years */
    var year = 1;

    $(".yearsspan").each(function () {
        $(this).html(year);
    });




    /*-----------------------------------------------------------------------------*/

    /* Get our first value */
    var monthlySavings = removeChars($('#monthly-savings').val()).replace(/\.(.*)/, "");

    /* No point carrying on if we aren't doing anything */
    if (!monthlySavings || monthlySavings <= 0) {
        return;
    }


    /* Put the value back formatted but make sure we aren't getting in the way of the user */
    if (focus != "monthly-savings") {

        if (parseFloat(monthlySavings) < parseFloat(minAmount)) {
            monthlySavings = minAmount;
            update = true;
            alert("Your contribution amount needs to at least be $2, we've adjusted this number for you");
        } else if (parseFloat(monthlySavings) > parseFloat(maxAmount)) {
            monthlySavings = maxAmount;
            update = true;
            alert("Your contribution amount can't be more than $1000, we've adjusted this number for you");
        }
        const inputFields = ['monthly-savings', 'total-savings', 'yearly-savings', 'match-value', 'match-total', 'num-shares'];

        inputFields.forEach((id) => {
            const input = document.getElementById(id);

            input.addEventListener('input', function(event) {
                if (!input.value) {
                    // If the input field is empty, clear all other input fields
                    inputFields.filter((fieldId) => fieldId !== id)
                        .forEach((fieldId) => {
                            document.getElementById(fieldId).value = '';
                        });
                }
            });
        });

        $('#monthly-savings').val(currency + commify(parseFloat(monthlySavings)));
    } else {
        $('#monthly-savings').val(monthlySavings);
    }

    var totalSavings = monthlySavings * (year * 26);
    $('#total-savings').val(currency + commify(totalSavings.toFixed(2)));

    var matchValue = totalSavings * 0.15;


    if (parseFloat(matchTotal) < 0) {
        matchTotal = 0;
    }
    if (parseFloat(matchValue) > 270) {
        matchValue = 270;
    } else {
        matchValue = totalSavings * 0.15;
    }

    var matchTotal = totalSavings + matchValue;
    if (parseFloat(matchTotal) < 0) {
        matchTotal = 0;
    }
    if (parseFloat(matchValue) > 1800) {
        matchTotal = 270 + totalSavings;
    } else {
        matchTotal = totalSavings + matchValue;
    }

    $('#match-value').val(currency + commify((matchValue).toFixed(2)));
    $('#match-total').val(currency + commify((matchTotal).toFixed(2)));
    $('#yearly-savings').val(currency + commify(totalSavings.toFixed(2)));
    /*-----------------------------------------------------------------------------*/

    const inputField = ['option-price', 'num-shares'];

    inputField.forEach((id) => {
        const input = document.getElementById(id);

        input.addEventListener('input', function(event) {
            if (!input.value) {
                // If the input field is empty, clear all other input fields
                inputField.filter((fieldId) => fieldId !== id)
                    .forEach((fieldId) => {
                        document.getElementById(fieldId).value = '';
                    });
            }
        });
    });


    /* Floor it by stripping off everything after the . */
    /* Get our Option value */

    var optionPrice = removeChars($('#option-price').val());

    /* No point carrying on if we aren't doing anything */
    if (!optionPrice || optionPrice <= 0) {
        return;
    }

    /* Put the value back formatted but make sure we aren't getting in the way of the user */
    if (focus != "option-price") {


        $('#option-price').val(currency + commify(parseFloat(optionPrice).toFixed(2)));
    } else {
        $('#option-price').val(optionPrice);
    }
    var numShares = matchTotal / optionPrice;
    $('#num-shares').val(commify(parseFloat(numShares).toFixed(3)));

    if (update) {
        reupdate();
    }



}

/* Does what it says on the tin */
function commify(val) {
    return val.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/* To strip numbers down to usable state*/
function removeChars(str) {

    var patt = new RegExp("[0-9]");
    var patt2 = new RegExp("[\.]");

    var newstr = '';
    var gotdec = false;
    var postdec = 0;

    for (var x = 0; x < str.length; x++) {
        var c = str.charAt(x);
        if (patt.exec(c)) {
            newstr = newstr + c;
            if (gotdec) {
                postdec += 1;
            }
        } else if (patt2.exec(c) && !gotdec) {
            newstr = newstr + c;
            gotdec = true;
        }
        if (postdec > 1) {
            x = str.length;
        }

    }

    return newstr;

}