<?php
/**
 * @var Entity\User $u
 */
?>
<?= form_open('#', ['class' => 'span5 offset1', 'id' => 'user_form']) ?>
<div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" class="span5" value="<?= $u->getUser(); ?>" readonly/>
</div>

<div>
    <label for="password">Password (<em>để trống nếu muốn giữ nguyên</em>)</label>
    <input type="password" id="password" name="password" class="span5"/>
</div>

<div>
    <label for="email">Email</label>
    <input type="text" id="email" name="email" class="span5" value="<?= $u->getEmail() ?>"/>
</div>

<div>
    <label for="name">Name</label>
    <input type="text" id="name" name="name" class="span5" value="<?= $u->getName() ?>"/>
</div>

<div>
    <label for="roles">Role</label>
    <?= $u->getRoleDropdown('roles', ['class' => 'span5']); ?>
</div>
<?= form_close() ?>

<script>
    // Update title
    $("#modal_label", "#bs_modal").text("Update User <?= $u->getUser() ?>");
</script>