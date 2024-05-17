
$(document).ready(function () {

    $("#category_form").on("submit", function (event) {
        event.preventDefault();
        $(".submit").attr("disabled", true);

        if ($("#category_form").parsley().isValid()) {
            var formData = new FormData(this);
            $.ajax({
                url: categoryURL,
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
                    $(".submit").val("Submitting...");
                },
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout((window.location.href = categoryIndexURL), 2000);
                        $(".submit").val("Submit");
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (response) {
                    $(".submit").attr("disabled", false);
                    toastr.error(response.responseJSON.errors);
                },
            });
        } else {
            $(".submit").attr("disabled", false);
            return false;
        }
    });

    $("body").on("click", ".deletecategory", function () {
        var id = $(this).data("id");

        swal({
            title: `Are you sure you want to delete this category?`,
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
                    url: categoryURL + "/" + id,
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

    function isNumber(event) {
        var event = (event) ? event : window.event;
        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
            return false;

        }
    }

});




$(document).on("change", ".id_check", function () {
   var ids=  $('.id_check').filter(':checked').length;
 
   if(ids>0){
    $('#bulkDeleteBTN').show();
 }else{$('#bulkDeleteBTN').hide();}

         });

         
$(document).on("click", "#bulkDeleteBTN", function () {
    var selected=[];
    var ids=  $('.id_check').filter(':checked').each(function() {
        selected.push($(this).val());
   });
   $.ajax({
    type: "post",
    dataType: "json",
    url: bulkDelete,
    data: {
        ids: selected,
        _token: crsf,
        
    },
    success: function(data) {
        toastr.success(data.message);
        setTimeout(location.reload(), 2000);

    },
    error: function(data) {
        toastr.error(data);
    },
});
   
          });
 

$(document).on("change", ".toggle-class", function () {
     var status = $(this).prop("checked") == true ? 1 : 0;
     var categoryId = $(this).data("id");
     var change = '';
     if(status == 1){
         change = 'Enable';
     } else {
         change = 'Disable';
     }

     swal({
             title: 'Are you sure you want to ' + change + ' the category?',
             buttons: true,
             dangerMode: true,
         }).then((willDelete) => {
                 if (willDelete) {

                     $.ajax({
                         type: "GET",
                         dataType: "json",
                         url: changeStatus,
                         data: {
                             status: status,
                             category_id: categoryId
                         },
                         success: function(data) {
                             toastr.success(data.message);
                            //  setTimeout(location.reload(), 2000);
                         },
                         error: function(data) {
                             toastr.error(data);
                         },
                     });
                 }else{
                     const isChecked = $(`.status_${categoryId}`).is(":checked");

                     if(isChecked == true){
                     $(`.status_${categoryId}`).prop('checked', false);
                     }else{
                        $(`.status_${categoryId}`).prop('checked', true);

                     }
                    }
                 });
         });

