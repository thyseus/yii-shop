<?php


$this->Widget('CTreeView', array(
	'data' => Category::getChilds(0),
	'animated' => 'slow',	
	'collapsed' => 'true',	
	'persist' => 'cookie',	
	));

?>
