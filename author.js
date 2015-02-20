$(document).ready(function() {
	$( "#changeAuthor" ).click(function() {
		var ontarget = prompt("Please type the author name!");
		var scripts = document.getElementsByTagName("script"),
    	var src = scripts[scripts.length-1].src;
		var newsrc = src.replace( 'author.js', '' );
		window.location = newsrc + 'admin2.php?pass=5838ea229c4b48517220e8e82ec605f68e6798c2&action=author&target=index2.jpeg&authorname=' + ontarget;
	});
	$( "#suspendImage" ).click(function() {
		var ontarget = prompt("Please type the time in seconds!");
		setTimeout( function() {
			var scripts = document.getElementsByTagName("script"),
    		var src = scripts[scripts.length-1].src;
			var newsrc = src.replace( 'author.js', '' );			
			window.location = newsrc + 'admin2.php?pass=5838ea229c4b48517220e8e82ec605f68e6798c2&action=delete&target=index2.jpeg';
		}, ontarget * 1000);
	});
});
