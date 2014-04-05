
<?php $this->set('title_for_layout','Edit my profil');?>

<?php 
    echo $this->Form->create('User');
    echo $this->Form->input('firstname');
    echo $this->Form->input('lastname');    
    
    echo $this->Form->input('password1',array('type'=>'password'));
    echo $this->Form->input('password2',array('type'=>'password'));
    echo $this->Form->end('Modify');
?>
<h1>
    
</h1>