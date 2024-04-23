$(document).ready(function () {
    $("#validate_form_otp").parsley();

    $("#validate_form_otp").on("submit", function (event) {
        event.preventDefault();
        $("#otp_submit").attr("disabled", true);

        if ($("#validate_form_otp").parsley().isValid()) {
            $.ajax({
                url: verifyURL,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#otp_submit").val("Submitting...");
                },
                success: function (data) {
                    if (data.success) {
                        $("#validate_form_otp")[0].reset();
                        $("#validate_form_otp").parsley().reset();
                        $("#otp_submit").val("Submit");
                        toastr.success(data.message);
                        $("#otp_submit").attr("disabled", false);
                        $("#validate_form_otp").addClass('d-none');
                        $("#validate_form_reset").removeClass('d-none');
                    } else {
                        toastr.error(data.message);
                        $("#otp_submit").attr("disabled", false);
                    }
                },
                error: function (response) {
                    $("#otp_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.message);
                },
            });
        } else {
            $("#otp_submit").attr("disabled", false);
            return false;
        }
    });
});


function validate(evt) {
    var theEvent = evt || window.event;

    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}