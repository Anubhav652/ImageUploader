$(document).ready(function() {
	$( "#changeAuthor" ).click(function() {
		var ontarget = prompt("Please type the author name!");
		window.location = 'http://localhost/image/admin2.php?pass=5838ea229c4b48517220e8e82ec605f68e6798c2&action=author&target=index2.jpeg&authorname=' + ontarget;
	});
});
