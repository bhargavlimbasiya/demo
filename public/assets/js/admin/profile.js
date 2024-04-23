$(document).ready(function () {
    $("#validate_form_profile").parsley();

    $("#validate_form_profile").on("submit", function (event) {
        event.preventDefault();
        $("#kt_account_profile_details_submit").attr("disabled", true);

        if ($("#validate_form_profile").parsley().isValid()) {
            var formData = new FormData(this);
            $.ajax({
                url: profileURL,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#kt_account_profile_details_submit").val("Submitting...");
                },
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message)
                        setTimeout(location.reload(), 2000);
                        $("#kt_account_profile_details_submit").val("Submit");
                    }else{
                        toastr.error(data.message);
                    }
                },
                error: function (response) {
                    $("#kt_account_profile_details_submit").attr("disabled", false);
                    toastr.error(response.responseJSON.errors);
                },
            });
        } else {
            $("#kt_account_profile_details_submit").attr("disabled", false);
            return false;
        }
    });
});