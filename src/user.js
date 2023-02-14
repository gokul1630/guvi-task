const userName = $("#user-name")
const userEmail = $("#user-email")
const userAge = $("#user-age")
const userDob = $("#user-dob")
const userMobile = $("#user-mobile")
const saveBtn = $("#save-btn")
const signOutBtn = $("#signout-btn")
const editBtn = $("#edit-btn")

saveBtn.hide()

window.onload = function () {
    const user = localStorage.getItem("user")

    if (user) {
        const data = JSON.parse(user)
        const { name, email, age, dob, mobile } = data
        userEmail.val(email)
        userName.val(name)
        userAge.val(age)
        userDob.val(dob)
        userMobile.val(mobile)
    } else {
        window.location.href = "index.html"
    }
}

editBtn.click(function () {
    userName.prop("disabled", false)
    userDob.prop("disabled", false)
    userMobile.prop("disabled", false)
    userAge.prop("disabled", false)
    editBtn.hide()
    saveBtn.show()
    signOutBtn.hide()
})

saveBtn.click(function () {
    $.ajax({
        url: "server.php",
        type: "POST",
        data: {
            save: "",
            name: userName.val(),
            mail: userEmail.val(),
            age: userAge.val(),
            dob: userDob.val(),
            mobile: userMobile.val(),
        },
        success: function (data) {
            if (data) localStorage.setItem("user", JSON.stringify(data))
            userName.prop("disabled", true)
            userEmail.prop("disabled", true)
            userDob.prop("disabled", true)
            userMobile.prop("disabled", true)
            userAge.prop("disabled", true)
            editBtn.show()
            saveBtn.hide()
            signOutBtn.show()
            window.location.reload()
        },
        error: function (error) {
            alert(parseResponse(error.responseText))
        },
    })
})

signOutBtn.click(function () {
    $.ajax({
        url: "server.php",
        type: "POST",
        data: {
            delete: "",
        },
        success: function (data) {
            localStorage.removeItem("user")
            window.location.href = "index.html"
        },
        error: function (error) {
            alert(parseResponse(error))
        },
    })
})

function saveToLocal(data) {
    if (data) localStorage.setItem("user", JSON.stringify(data))
}
