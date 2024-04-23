$(document).ready(function () {
    $("#validate_form_reset").parsley();

    $("#validate_form_reset").on("submit", function (event) {
        event.preventDefault();
        $("#kt_new_password_submit").attr("disabled", true);

        if ($("#validate_form_reset").parsley().isValid()) {
            $.ajax({
                url: resetURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#kt_new_password_submit").val("Submitting...");
                },
                success: function (data) {

                    if (data.success) {
                        $("#validate_form_reset")[0].reset();
                        $("#validate_form_reset").parsley().reset();
                        $("#kt_new_password_submit").val("Submit");
                        toastr.success(data.message);
                        $("#kt_new_password_submit").attr("disabled", false);
                        window.location.href = homeURL;
                    } else {
                        toastr.error(data.message);
                        $("#kt_new_password_submit").attr("disabled", false);
                    }
                },
                error: function (response) {
                    $("#kt_new_password_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.message);
                },
            });
        } else {
            $("#kt_new_password_submit").attr("disabled", false);
            return false;
        }
    });
});



