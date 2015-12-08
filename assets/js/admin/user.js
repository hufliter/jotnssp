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
            null,
            null,
            { sortable: false }
        ],
        processing: true,
        serverSide: true
    });

    $table.on('click', '.control.edit', function ()
    {
        var $self = $(this),
            id = $self.data('id'),
            ep = $table.data('edit') + '/' + id // endpoint to update
        ;

        currentOp.mode = 'update';
        currentOp.id = id;
        currentOp.ep = ep;
        $table.isLoading({text: "loading...",  position:   "overlay"});

        $.get(ep, {}, function (resp) {
            $table.isLoading("hide");
            $modal.find('.modal-body')
                .html(resp);
            $modal.modal("show");
        }, 'html');
    });

    $table.on('click', '.control.reseller', function () {
        var $self = $(this),
            id = $self.data('id');

        location.href = $table.data('reseller') + "/" + id;
    });

    $table.on('click', '.control.delete', function () {
        var $self = $(this);
        noty({
            text: "Bạn muốn xóa user: " + $self.data("username") + "?",
            buttons: [
                {
                    addClass: "btn btn-normal",
                    text: "Cancel",
                    onClick: function ($noty) { $noty.close(); }
                }
            ]
        })
    });

    $(".btn-primary", $modal).click(function () {
        var $form = $("#user_form"),
            formData = $form.serializeJSON();
        if (currentOp.mode == "update") {
            updateUser(formData);
        }
    });

    /**
     * @param data
     */
    function updateUser(data) {
        $.isLoading({text: "Updating...", position: "overlay"});
        $.post(currentOp.ep, data, function (resp) {
            $modal.modal("hide");
            noty({text: "Cập nhật thành công.", type: "success", layout: "topCenter", timeout: 3000});
            $table.dataTable().api().ajax.reload();
        }, 'json')
            .always(function () {
                $.isLoading("hide");
            })
            .error(function () {
                noty({text: "Xảy ra lỗi, vui lòng kiểm tra lại.", type: "error", layout: "center"})
            });
    }
});