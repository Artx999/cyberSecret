class CheckIcon {
    constructor() {
        this.content = $("<div>...</div>")
    }
}

function checkButton(checks) {
    let disable = true
    for (let i in checks) {
        if (checks[i] === false) {
            disable = true
            break
        }
        else disable = false
    }
    $("#submit").prop("disabled", disable)
}

let timer
let checks = {}
checkButton(checks)
$(["username", "password", "confirmPassword", "seatNumber"]).each(function () {
    let type = this.toString()
    let icon = new CheckIcon()
    let input = $("#" + type)
    checks[type] = false

    $(input).after(icon.content)
    $(input).on("change keyup paste", function () {
        let val = $(input).val()
        // Check if username fits proper parameters
        if (!val) {
            $(icon.content).attr("class", "none")
                .html("...")
            checks[type] = false
            checkButton(checks)
            return
        }
        if (type === "username") {
            if (typeof val !== "string") {
                $(icon.content).attr("class", "bad")
                    .html("Input must be string")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val.length > 25) {
                $(icon.content).attr("class", "bad")
                    .html("Username cannot be longer than 25 characters!")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
        }
        if (type === "password" || type === "confirmPassword") {
            let confirmPassword = $("#confirmPassword")
            if (typeof val !== "string") {
                $(icon.content).attr("class", "bad")
                    .html("Input must be string")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val.length > 255) {
                $(icon.content).attr("class", "bad")
                    .html("Password cannot be longer than 255 characters!")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (!$(confirmPassword).val()) {
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if ((type === "password" && val !== $(confirmPassword).val()) || (type === "confirmPassword" && val !== $("#password").val())) {
                $(confirmPassword).next().attr("class", "bad")
                    .html("Passwords must match!")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else {
                $(confirmPassword).next().attr("class", "ok")
                    .html("Good!")
                clearTimeout(timer)
                checks["confirmPassword"] = true
                checks["password"] = true
                checkButton(checks)
                return
            }
        }
        if (type === "seatNumber") {
            if (isNaN(+val)) {
                $(icon.content).attr("class", "bad")
                    .html("Input must be number")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val < 1 || val > 172) {
                $(icon.content).attr("class", "bad")
                    .html("Input must be between 1 and 172")
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
        }
        // Check if username or seatNumber already exists
        if (type === "username" || type === "seatNumber") {
            $(icon.content).attr("class", "wait")
            let payload = {}
            payload[type] = val
            clearTimeout(timer)
            timer = setTimeout(function () {
                if (!$(input).val()) {
                    $(icon.content).attr("class", "none")
                        .html("...")
                    return
                }
                $.post("backend/checkIfExists.php", payload, function (data) {
                    if (data === "error") {
                        $(icon.content).attr("class", "bad")
                            .html("Error!")
                        checks[type] = false
                        checkButton(checks)
                    } else if (data) {
                        $(icon.content).attr("class", "bad")
                            .html("Already exists!")
                        checks[type] = false
                        checkButton(checks)
                    } else {
                        $(icon.content).attr("class", "ok")
                            .html("Valid input")
                        checks[type] = true
                        checkButton(checks)
                    }
                })
                    .fail(function () {
                        $(icon.content).attr("class", "bad")
                            .html("Error")
                        checks[type] = false
                        checkButton(checks)
                    })
            }, 1000)
        }
        console.log(checks)
    })
})

// Todo: Make better variable and class names
// Todo: Make it work for every input, and with the correct checks