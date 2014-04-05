<h1>Sign up</h1>
<?php 

echo $this->Form->create('User');
echo $this->Form->input('username',array('label'=>'login'));
echo $this->Form->input('password',array('label'=>'Password'));
echo $this->Form->input('repassword',array('label'=>'Confirm your password','type'=>'password'));

echo $this->Form->end('Save user');
?>