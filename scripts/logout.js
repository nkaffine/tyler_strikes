/**
 * Created by Nick on 2/21/18.
 */
$(document).ready(function () {
    $("#logout").click(function () {
        $.getJSON("/process/logout.php", function (data) {
            if (data.error !== null) {
                //Throw some sort of error
            }
            if (data.results !== null) {
                window.location = "/";
            }
        })
    });
});
