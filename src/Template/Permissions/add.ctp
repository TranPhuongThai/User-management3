<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */
use Cake\Log\Log;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Permissions'), ['action' => 'view']) ?></li>
    </ul>
</nav>
<div class="permissions form large-9 medium-8 columns content">
    <?= $this->Form->create($permission) ?>
    <fieldset>
        <legend><?= __('Add Permission') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('controller');
            echo 'Status';
            echo $this->Form->select('status', [1 => 'On', 0 => 'Off']);
            echo 'Roles: ';
            echo $this->Form->select('role_id', $roles, ['multiple' => 'checkbox']);
        ?>
    </fieldset>
    

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
