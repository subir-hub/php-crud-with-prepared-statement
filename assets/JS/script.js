$(document).ready(function () {

    $("input, select").on("keyup change", function () {
        $(this).parent().find(".error").text("");
    });

    $("#regForm").on("submit", function (e) {
        e.preventDefault();

        let name = $("#name").val().trim();
        let email = $("#email").val();
        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let gender = $("input[name='gender']:checked").val();
        let city = $("#city").val();
        let terms = $("#terms").is(":checked");
        let flag = true;

        if (name == "") {
            $("#nameError").text("Name is required");
            flag = false;
        }

        if (email == "") {
            $("#emailError").text("Email is required");
        } else if (!emailRegex.test(email)) {
            $("#emailError").text("Enter a valid email");
        }

        if (!gender) {
            $("#genderError").text("Gender is required");
            flag = false;
        }

        if (city == "") {
            $("#cityError").text("City is required");
            flag = false;
        }

        if (!terms) {
            $("#termsError").text("You must accept the terms and conditions");
            flag = false;
        }

        if (flag) {
            let formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: formData + '&action=insert',
                dataType: "json",
                success: function (response) {
                    if (response.code === 200) {
                        $("#result").text(response.msg).css("color", "green").fadeIn().delay(3000).fadeOut();

                        setTimeout(() => {
                            window.location.href = '../../display.php';
                        }, 3000);
                    } else {
                        $("#result").text(response.msg).css("color", "red").fadeIn().delay(3000).fadeOut();
                    }
                }
            });
        }
    });

    $("#updateForm").on("submit", function (e) {
        e.preventDefault();

        let updateData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: updateData + '&action=update',
            dataType: "json",
            success: function (response) {
                if (response.code === 200) {
                    $("#result").text(response.msg).css("color", "green").fadeIn().delay(3000).fadeOut();

                    setTimeout(() => {
                        window.location.href = '../../display.php';
                    }, 3000);
                } else {
                    $("#result").text(response.msg).css("color", "red").fadeIn().delay(3000).fadeOut();
                }
            }
        });
    })
});
