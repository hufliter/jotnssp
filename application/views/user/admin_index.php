<div class="row-fluid">
    <div class="span12 round">
        <h3>Users List</h3>
    </div>
</div>
<!-- content -->
<div class="row-fluid well well-small">
    <table id="table_data" class="display"
           data-ajax="<?= base_url() ?>admincp/user/apiGet"
           data-edit="<?= base_url()?>admincp/user/apiEdit"
           data-reseller="<?= base_url() ?>admincp/reseller/show"
        >
        <thead>
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td>Reseller Code</td>
            <td>Controls</td>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<?= $bs_modal ?>
<script src="<?= base_url() ?>assets/js/admin/user.js"></script>