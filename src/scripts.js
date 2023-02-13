const userName = $("#user-name")
const email = $("#user-email")
const age = $("#user-age")
const dob = $("#user-dob")
const mobile = $("#user-mobile")

$("#submit-btn").click(function () {
    const mail = $("#mail").val()
    const password = $("#password").val()
    if (mail !== "" && password !== "") {
        $.ajax({
            type: "POST",
            data: {
                mail: mail,
                pass: password,
                login: "",
            },
            url: "server.php",
            success: function (data) {
                saveToLocal(data)
                window.location.href = "user.html"
            },
            error: function (error) {
                alert(parseResponse(error.responseText))
            },
        })
    } else {
        alert("All fields required")
    }
})

$("#signup-submit-btn").click(function () {
    const name = $("#signup-name").val()
    const mail = $("#sign-up-mail").val()
    const password = $("#signup-password").val()

    if (mail !== "" && password !== "" && name !== "") {
        $.ajax({
            type: "POST",
            data: {
                name: name,
                mail: mail,
                pass: password,
            },
            url: "server.php",
            success: function (data) {
                saveToLocal(data)
                window.location.href = "user.html"
            },
            error: function (error) {
                alert(parseResponse(error.responseText))
            },
        })
    } else {
        alert("All fields required")
    }
})

function parseResponse(data) {
    try {
        return JSON.parse(data).message
    } catch (error) {
        return error
    }
}

function saveToLocal(data) {
    if (data) localStorage.setItem("user", JSON.stringify(data))
}
