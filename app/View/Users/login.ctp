<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Please enter your login and your password'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Html->link('Password forgotten?',array('controller'=>'users','action'=>'password'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Connexion'));?>
</div>