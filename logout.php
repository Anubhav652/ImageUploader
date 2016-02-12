<?php
	setcookie("LoggedIn", "", time()-3600);
	echo '<script>
		location.href = "index.php";
	</script>';
?>
