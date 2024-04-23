$(document).ready(function () {
    $("#validate_form_password").parsley();

    $("#validate_form_password").on("submit", function (event) {
        event.preventDefault();
        $("#kt_password_submit").attr("disabled", true);

        if ($("#validate_form_password").parsley().isValid()) {
            $.ajax({
                url: passwordURL,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#kt_password_submit").val("Submitting...");
                },
                success: function (data) {
                    $("#kt_password_submit").attr("disabled", false);
                    if (data.success) {
                        toastr.success(data.message);
                        $("#validate_form_password")[0].reset();
                        $("#validate_form_password").parsley().reset();
                        $("#kt_password_submit").val("Submit");
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (response) {
                    $("#kt_password_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.errors);
                },
            });
        } else {
            $("#kt_password_submit").attr("disabled", false);
            return false;
        }
    });
});
