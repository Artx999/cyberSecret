class CheckIcon {
    constructor() {
        this.content = $("<div></div>")
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
$(["username", "password", "confirmPassword", "cardID", "firstName", "lastName"]).each(function () {
    let type = this.toString()
    let icon = new CheckIcon()
    let input = $("#" + type)
    checks[type] = false

    function checkInput() {
        let val = $(input).val()
        // Checks if input is empty
        if (!val) {
            $(icon.content).attr("class", "none")
                .html('')
            checks[type] = false
            checkButton(checks)
            return
        }
        // Checks username
        if (type === "username") {
            if (typeof val !== "string") {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val.length > 25) {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
        }
        // Checks password and confirmPassword
        if (type === "password" || type === "confirmPassword") {
            let confirmPassword = $("#confirmPassword")
            if (typeof val !== "string") {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val.length > 255) {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
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
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else {
                $(confirmPassword).next().attr("class", "ok")
                    .html('<span class="material-icons">done</span>')
                clearTimeout(timer)
                checks["confirmPassword"] = true
                checks["password"] = true
                checkButton(checks)
                return
            }
        }
        // Checks card ID
        if (type === "cardID") {
            if (isNaN(+val)) {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val < 1 || val > 172) {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
        }
        // Checks first and last name
        if (type === "firstName" || type === "lastName") {
            if (typeof val !== "string") {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else if (val.length > 255) {
                $(icon.content).attr("class", "bad")
                    .html('<span class="material-icons">close</span>')
                clearTimeout(timer)
                checks[type] = false
                checkButton(checks)
                return
            }
            else {
                $(icon.content).attr("class", "ok")
                    .html('<span class="material-icons">done</span>')
                clearTimeout(timer)
                checks[type] = true
                checkButton(checks)
                return
            }
        }
        // Check if username or cardID already exists
        if (type === "username" || type === "cardID") {
            $(icon.content).attr("class", "wait")
            let payload = {}
            payload[type] = val
            clearTimeout(timer)
            timer = setTimeout(function () {
                if (!$(input).val()) {
                    $(icon.content).attr("class", "none")
                        .html("")
                    return
                }
                $.post("backend/checkIfExists.php", payload, function (data) {
                    if (data === "error") {
                        $(icon.content).attr("class", "bad")
                            .html('<span class="material-icons">error</span>')
                        console.log("Error!")
                        checks[type] = false
                        checkButton(checks)
                    } else if (data) {
                        $(icon.content).attr("class", "bad")
                            .html('<span class="material-icons">close</span>')
                        checks[type] = false
                        checkButton(checks)
                    } else {
                        $(icon.content).attr("class", "ok")
                            .html('<span class="material-icons">done</span>')
                        checks[type] = true
                        checkButton(checks)
                    }
                })
                    .fail(function () {
                        $(icon.content).attr("class", "bad")
                            .html('<span class="material-icons">error</span>')
                        console.log("Error!")
                        checks[type] = false
                        checkButton(checks)
                    })
            }, 500)
        }
    }

    $(input).after(icon.content)
    $(input).on("change keyup paste", checkInput)
    checkInput()
})

// Todo: Make better variable and class names