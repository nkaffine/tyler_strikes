/**
 * Created by Nick on 2/21/18.
 */
//Displays an error panel with the given header and message
//Requires that there is a div with the id error on the page
function displayError(header, message) {
    html = "<div class=\"panel panel-default panel-danger\"><div class=\"panel-heading\">"+header+"</div>" +
        "<div class=\"panel-body\">" + message + "</div></div>";
    $("#error").html(html);
}