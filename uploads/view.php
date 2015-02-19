<?php
	echo '<b style="color: yellow;">Author: <i style="color: green;">';
	echo file_get_contents( $_GET['name'].".info" );
	echo '</i></b><br>';
	echo '<img src="'.$_GET['name'].'" />';
?>
