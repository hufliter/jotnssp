$(function () {
    "use strict";
    var $table = $("#table_data"),
        $modal = $("#bs_modal"),
        currentOp = {
            mode: 'update',
            id: 0,
            ep: ''
        };

    $table.dataTable({
        columns: [
            null,
            null,
            null,
            null,
            {sortable: false},
            null,
            {sortable: false}
        ],
        processing: true,
        serverSide: true,
        ajax: $table.data('ajax-base') + "/api-index"
    });
});