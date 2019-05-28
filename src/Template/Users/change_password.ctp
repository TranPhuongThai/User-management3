<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Change password') ?></legend>
        <?php
            echo $this->Form->control('old_password');
            echo $this->Form->control('new_password');
            echo $this->Form->control('confirm_new_password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirm')) ?>
    <?= $this->Form->end() ?>
</div>