<?php $this->set('title_for_layout','Refound password forgotten');?>

<?php 

echo $this->Form->create('User');
echo $this->Form->input('username',array('label'=>'Your login'));
echo $this->Form->end('Submit');
?>