/**
 * Created by Nick on 3/11/18.
 */
function newStrike(isBad) {
    let newStrike = $("#newStrike");
    if (newStrike.val().length > 255) {
        displayError("Error Processing Strike:", "Strike can have maximum 255 characters");
    } else {
        let link = "/process/newStrike.php?command=";
        let command = encodeURIComponent("newStrike");
        let user = encodeURIComponent(getUserId());
        let description = encodeURIComponent(newStrike.val());
        let type = null;
        if (isBad) {
            type = "bad";
        } else {
            type = "good";
        }
        encodeURIComponent(type);
        link += command + "&user=" + user + "&description=" + description + "&type=" + type;
        $.getJSON(link, processNewStrike);
    }
}

function processNewStrike(data) {
    if (data.error !== null) {
        displayError("Error Processing Strike:", data.error);
    }
    if (data.results !== null) {
        clearError();
        $("#newStrike").val("");
        displayStrikes();
    }
}

$(document).ready(function () {
    $("#goodStrike").click(function () {
        newStrike(false);
    });
    $("#badStrike").click(function () {
        newStrike(true);
    });
});