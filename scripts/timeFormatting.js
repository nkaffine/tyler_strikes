/**
 * Created by Nick on 7/10/17.
 */
function userTime(time){
    var things = time.split("-");
    var year = things[0];
    var month = things[1];
    var day_hours = things[2].split(" ");
    var day = day_hours[0];
    var times = day_hours[1];
    times = times.split(':');
    var hours = times[0];
    var minutes = times[1];
    var date = new Date(year, month, day, hours, minutes, 0, 0);
    var offset = new Date().getTimezoneOffset();
    date = new Date(date.setMinutes(date.getMinutes() - offset));
    date = new Date(date.setMinutes(date.getMinutes() + 7 * (60)));
    if (date.getHours() >= 12){
        var tt = "PM";
        var hours = date.getHours()%12;
        if(hours == 0){
            hours = 12;
        }
    } else {
        var tt = "AM";
        var hours = date.getHours();
        if(hours == 0){
            hours = 12;
        }
    }
    var minutes = date.getMinutes()
    if(minutes < 10){
        minutes = "0" + minutes;
    }
    var dateString = (date.getMonth())+"/"+date.getDate()+"/"+date.getFullYear()+" "+hours+":"+minutes+tt;
    return dateString;
}

function userTime2(time){
    var things = time.split("-");
    var year = things[0];
    var month = things[1];
    var day_hours = things[2].split(" ");
    var day = day_hours[0];
    var times = day_hours[1];
    times = times.split(':');
    var hours = times[0];
    var minutes = times[1];
    var date = new Date(year, month, day, hours, minutes, 0, 0);
    if(time == "None"){
        return "None";
    }
    var offset = new Date().getTimezoneOffset()
    date = new Date(date.setMinutes(date.getMinutes() - offset));
    date = new Date(date.setMinutes(date.getMinutes() + 7 * (60)));
    var dateString = (date.getMonth())+"/"+date.getDate()+"/"+date.getFullYear();
    return dateString;
}
function userTime2NoShift(time){
    if(time == "None"){
        return "None";
    }
    var offset = new Date().getTimezoneOffset();
    var date = new Date(new Date(time));
    date = new Date(date.setMinutes(date.getMinutes() - offset));
    var dateString = (date.getMonth()+1)+"/"+date.getDate()+"/"+date.getFullYear();
    return dateString;
}

$(document).ready(function () {

});