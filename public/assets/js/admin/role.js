$(document).ready(function () {
    $(".validate_form_role").parsley();

    $(".validate_form_role").on("submit", function (event) {
        event.preventDefault();
        $("#submit").attr("disabled", true);

        if ($(".validate_form_role").parsley().isValid()) {
            var formData = new FormData(this);
            $.ajax({
                url: roleURL,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#submit").val("Submitting...");
                },
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout((window.location.href = roleIndexURL), 2000);
                        $("#submit").val("Submit");
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (response) {
                    $("#submit").attr("disabled", false);
                    toastr.error(response.responseJSON.errors);
                },
            });
        } else {
            $("#submit").attr("disabled", false);
            return false;
        }
    });

    $("body").on("click", ".deleteRole", function () {
        var id = $(this).data("id");

        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                   
                    url: roleURL + "/" + id,
                    success: function (data) {
                        toastr.success(data.message);
                        setTimeout(location.reload(), 2000);
                    },
                    error: function (data) {
                        toastr.error(data);
                    },
                });
            }
        });
    });
});
