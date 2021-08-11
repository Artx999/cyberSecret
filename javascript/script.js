$(document).ready(function () {
    let checkIcon = new CheckIcon()
    let usernameInput = $("#username")
    $(usernameInput).after(checkIcon.content)
    $(usernameInput).on("change keyup paste", function () {
        let username = $(usernameInput).val()
        // Check if username fits proper parameters
        // Check if username already exists
        $(checkIcon.content).attr("class", "wait")
        $.post("backend/checkIfExists.php", {username: username}, function (data) {
            if (data) {
                $(checkIcon.content).attr("class", "bad")
                    .html("Already exists!")
            } else $(checkIcon.content).attr("class", "ok")
                .html("Valid input")
        })
            .fail(function () {
                $(checkIcon.content).attr("class", "bad")
                    .html("Error")
            })
    })
    // Password, confirm password, seat number
})

class CheckIcon {
    constructor() {
        this.content = $("<div>LOL</div>")
    }
}

// Todo: Make it work for both username and password, using loops av variable variable names
// Todo: Must also deactivate features until the input is confirmed unique