$(document).ready(function () {
    $("#validate_form_login").parsley();

    $("#validate_form_login").on("submit", function (event) {
        event.preventDefault();
        $("#kt_sign_in_submit").attr("disabled", true);

        if ($("#validate_form_login").parsley().isValid()) {
            $.ajax({
                url: loginURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#kt_sign_in_submit").val("Submitting...");
                },
                success: function (data) {
                    $("#validate_form_login")[0].reset();
                    $("#validate_form_login").parsley().reset();
                    $("#kt_sign_in_submit").val("Submit");
                    window.location.href = homeURL;
                },
                error: function (response) {
                    $("#kt_sign_in_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.message);
                },
            });
        } else {
            $("#kt_sign_in_submit").attr("disabled", false);
            return false;
        }
    });
});