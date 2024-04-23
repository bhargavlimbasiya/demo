$(document).ready(function() {
    loadUserData();

    function loadUserData() {
        var formdata = $('#search_form').serialize();

        $('#kt_table_users').dataTable().fnDestroy();
        $('#kt_table_users').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": false,
            "lengthChange": false,
            "ordering": true,
            "pageLength": 10,
            "bSortable": true,
            "paging": true,
            "retrieve": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "ajax": {
                url: userData + formdata,
                method: "get",
            },
            "columnDefs": [{
                'targets': [0],
                'orderable': true,
            }],
        });
    }

});
