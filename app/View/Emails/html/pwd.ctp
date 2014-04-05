<p>
    Hello <?php echo $lastname ?>,   
</p>

<p>
    you applied for a new password. If this is indeed the case, please click on the following link: <?php echo $this->Html->link('reset my password',$this->Html->url($link,true));  ?>
</p>