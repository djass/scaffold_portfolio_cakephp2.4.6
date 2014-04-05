<h1>Personal page Manager</h1>
<?php
echo "<h2>Raccourci</h2>";
echo "<ul>";
echo $this->Html->link("<li>Activities</li>",array('admin'=>true, 'controller'=>'Activities'),array('escape'=>false));
echo $this->Html->link("<li>Advertisements</li>",array('admin'=>true,'controller'=>'Advertisements'),array('escape'=>false));
echo $this->Html->link("<li>Organizations</li>",array('admin'=>true,'controller'=>'Organizations'),array('escape'=>false));
echo $this->Html->link("<li>Posts</li>",array('admin'=>true,'controller'=>'Posts'),array('escape'=>false));
echo "</ul></br><hr/>";