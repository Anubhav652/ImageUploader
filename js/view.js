function updateStuff() {
	var imaged = document.getElementsByClassName( "deleteImage" )[0];
	var attribute = document.getElementsByClassName( "deleteImage" )[0].getAttribute( "id" );

	imaged.onclick = function() {
		document.location = "view.php?action=authorDelete&image="+ attribute +"&redirect=index.php";
	}
}
setTimeout( updateStuff, 2500 );
