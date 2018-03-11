/**
 * Created by Nick on 3/11/18.
 */
function displayStrikes() {
    let link = "/process/getStrikes.php";
    $.getJSON(link, processStrikes);
}

function processStrikes(data) {
    let results = data.results.strikes;
    let html = "";
    for (let i = 0; i < results.length; i++) {
        html += displayStrike(results[i]);
    }
    $("#strikes").html(html);
    let strike_html = "<h1>Tyler Currently Has " + data.results.strike_status + " Strikes</h1>";
    $("#strikeStatus").html(strike_html);
}

function displayStrike(strike) {
    let html = "<div class='col-xs-12 no-pad'>";
    if (strike.type === "bad") {
        html += "<div class='panel panel-danger col-xs-12 no-pad'>";
    } else {
        html += "<div class='panel panel-success col-xs-12 no-pad'>";
    }
    html += "<div class=\"panel-heading\">" + strike.striker.username + " " + "<span class='time'>" +
        userTime(strike.date) + "</span>" + "</div>";
    html += "<div class=\"panel-body\">" + strike.description + "</div>";
    html += "</div>";
    html += "</div>";
    return html;
}

$(document).ready(function () {
    displayStrikes();
});