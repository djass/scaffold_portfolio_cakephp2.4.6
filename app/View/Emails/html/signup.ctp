<p>
    Hello <?php echo $lastname ?>,   
</p>

<p>
    To activate your account click on the next link : <?php echo $this->Html->link('Activate my account',$this->Html->url($link,true));  ?>
</p>