<?php
	echo '<b style="color: yellow;">Author: <i style="color: green;">';
	echo readfile( $_GET['name'].".info" );
	echo '</i></b>';
	echo '<img src="'.$_GET['name'].'" />';
?>
