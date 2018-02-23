/**
 * Created by Nick on 2/18/18.
 */
function getLink(type) {
    let email = $("#email").val();
    let username = $("#username").val();
    let password = $("#password").val();
    let link = "/process/login.php?";
    if (type === "login") {
        link += "type=" + encodeURIComponent("login");
        if(password !== "") {
            link += "&password=" + encodeURIComponent(password);
        }
        if (email === "" && username !== "") {
            link += "&username=" + encodeURIComponent(username);
        } else if (username === "" && email !== "") {
            link += "&email=" + encodeURIComponent(email);
        }

    } else if (type === "signup") {
        link += "type=" + encodeURIComponent("signup") + "&password=" + encodeURIComponent(password) + "&username=" +
            encodeURIComponent(username) + "&email=" + encodeURIComponent(email);
    }
    return link;
}

function handleLoginResponse(data) {
    if(data.error !== null) {
        displayError("Login error", data.error);
    } else {
        window.location = "/";
    }
}
$(document).ready(function () {
    $("#login").click(function () {
        let link = getLink("login");
        $.getJSON(link, handleLoginResponse);
    });
    $("#signup").click(function () {
        let link = getLink("signup");
        $.getJSON(link, handleLoginResponse)
    });
});
