function getStates(value) {
    $.post("backend/livesearchSys.php", {name:value},function(data){
            $("#results").html(data);
        }
    );
}

$(document).ready(function() {
    $("#username").on("change keyup paste", function() {
        if (!$("#username").val()) {
            $("#results").css("display", "none");
        } else {
            $("#results").css("display", "flex");
        }
    });
});