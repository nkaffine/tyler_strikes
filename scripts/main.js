/**
 * Created by Nick on 3/11/18.
 */
function getUserId() {
    return parseInt(document.cookie.substr(document.cookie.length - 1, 1));
}