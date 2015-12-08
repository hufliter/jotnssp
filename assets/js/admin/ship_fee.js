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
            { sortable: false }
        ],
        processing: true,
        serverSide: true,
        ajax: $table.data('ajax-base') + "/api-get-ship-fee"
    });

    $table.on('click', '.control.edit', function () {
        var $self = $(this),
            id = $self.data('id'),
            ep = $table.data('ajax-base') + "/api-get-ship-fee-edit/" + id;

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

    $table.on("click", ".control.delete", function () {
        var $self = $(this);
        noty({
            layout: 'center',
            modal: true,
            text: "Bạn muốn xóa " + $self.data("value") + "?",
            buttons: [
                {
                    addClass: "btn btn-normal",
                    text: "Cancel",
                    onClick: function ($noty) { $noty.close(); }
                },
                {
                    addClass: "btn btn-danger",
                    text: "Xóa",
                    onClick: function ($noty) {
                        $noty.close();
                        deleteWard($self.data('id'));
                    }
                }
            ]
        })
    });

    $(".btn-primary", $modal).click(function () {
        var $form = $("#_form"),
            formData = $form.serializeJSON();
        $.isLoading({text: "Processing...", position: "overlay"});
        $.post(currentOp.ep, formData, function () {
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
    });

    $("#btn_add").click(function () {
        var $self = $(this),
            ep = $self.data('ep');
        $.isLoading({text: "loading...", position: "overlay"});
        $.get(ep, {}, function (resp) {
            $.isLoading("hide");
            $modal.find('.modal-body').html(resp);
            $modal.modal("show");
            currentOp.mode = 'add';
            currentOp.ep = ep;
        }, 'html');
    });

    function deleteWard(id)
    {
        var data = {};
        data[JTS.csrf.name] = JTS.csrf.value;

        $table.isLoading({text: "loading...",  position:   "overlay"});
        $.post($table.data('ajax-base') + "/api-ship-fee-destroy/" + id, data, function (){
            $table.dataTable().api().ajax.reload();
        }).always(function () {
            $table.isLoading("hide");
        })
            .error(function () {
                noty({text: "Xảy ra lỗi, vui lòng kiểm tra lại.", type: "error", layout: "center"})
            });
    }
});