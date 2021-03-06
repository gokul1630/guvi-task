$("#save-btn").hide()

$("#submit-btn").click(function () {
	let mail = $("#mail").val()
	let password = $("#password").val()
	if (mail !== "" && password !== "") {
		$.ajax({
			type: "GET",
			data: {
				mail: mail,
				pass: password,
			},
			url: "server.php",
			success: function () {
				window.location.href = "user.php"
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
	let name = $("#signup-name").val()
	let mail = $("#sign-up-mail").val()
	let password = $("#signup-password").val()
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
				window.location.href = "user.php"
			},
			error: function (error) {
				alert(parseResponse(error.responseText))
			},
		})
	} else {
		alert("All fields required")
	}
})

$("#edit-btn").click(function () {
	$("#user-name").prop("disabled", false)
	$("#user-email").prop("disabled", false)
	$("#user-dob").prop("disabled", false)
	$("#user-mobile").prop("disabled", false)
	$("#user-age").prop("disabled", false)
	$("#edit-btn").hide()
	$("#save-btn").show()
	$("#signout-btn").hide()
})

$("#save-btn").click(function () {
	let name = $("#user-name").val()
	let mail = $("#user-email").val()
	let age = $("#user-age").val()
	let dob = $("#user-dob").val()
	let mobile = $("#user-mobile").val()

	$.ajax({
		url: "server.php",
		type: "POST",
		data: {
			save: "",
			name: name,
			mail: mail,
			age: age,
			dob: dob,
			mobile: mobile,
		},
		success: function (data) {
			window.location.reload()
			$("#user-name").prop("disabled", true)
			$("#user-email").prop("disabled", true)
			$("#user-dob").prop("disabled", true)
			$("#user-mobile").prop("disabled", true)
			$("#user-age").prop("disabled", true)
			$("#edit-btn").show()
			$("#save-btn").hide()
			$("#signout-btn").show()
		},
		error: function (error) {
			alert(parseResponse(error.responseText))
		},
	})
})

$("#signout-btn").click(function () {
	$.ajax({
		url: "server.php",
		type: "POST",
		data: {
			delete: "",
		},
		success: function (data) {
			window.location.href = "index.html"
		},
		error: function (error) {
			alert(parseResponse(error))
		},
	})
})

function parseResponse(data) {
	try {
		return JSON.parse(data).message
	} catch (error) {
		return error
	}
}
