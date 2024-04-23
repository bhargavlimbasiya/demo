$(document).ready(function () {
    $("#validate_form_email").parsley();

    $("#validate_form_email").on("submit", function (event) {
        event.preventDefault();
        $("#kt_password_reset_submit").attr("disabled", true);

        if ($("#validate_form_email").parsley().isValid()) {
            $.ajax({
                url: emailURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#kt_password_reset_submit").val("Submitting...");
                },
                success: function (data) {
                    $("#validate_form_email")[0].reset();
                    $("#validate_form_email").parsley().reset();
                    $("#kt_password_reset_submit").val("Submit");
                    toastr.success(data.message);
                    $("#kt_password_reset_submit").attr("disabled", false);

                },
                error: function (response) {
                    $("#kt_password_reset_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.message);
                },
            });
        } else {
            $("#kt_password_reset_submit").attr("disabled", false);
            return false;
        }
    });
});
