function trueOrFalseOfSelectBox( ) {
	var y = document.getElementById( "sel1" ).getAttribute("class");
	var s = y.split( " " );
	if (s[0] == "no-images") {
		return false;
	}
	return true;
}

function images() {
	if (trueOrFalseOfSelectBox()) {
	var e = document.getElementById("sel1");
	var restrict = document.getElementsByClassName( "restrict" )[0]
	var strUser = e.options[e.selectedIndex].value;
	var str = e.options[e.selectedIndex].innerHTML;
	var image = document.getElementById("imagetoshow");
	var split = str.split( ":")[3]
	if (split == ' Yes') {
		restrict.innerHTML = "Remove restrictions"
	} else {
		restrict.innerHTML = 'Restrict image to admins'
	}
	image.innerHTML = "<image src='uploads/"+strUser+"' width='250' height='250' class='img-thumbnail'/><br><b class='alert-danger'>Note: This image size is different from the original one!</b>"
	
}
}
setInterval( images, 500 );

function restrict2( restrictType, target ) {
	var restrict = document.getElementsByClassName( "restrict" )[0]
	if (restrictType == true) {
		document.location = "admin2.php?action=restrict&target=" + target;
	} else {
		document.location = "admin2.php?action=remover&target=" + target;
	}
}

function ss() {
	if (trueOrFalseOfSelectBox()) {
		var imaged = document.getElementsByClassName( "imaged" )[0]
		var deleted = document.getElementsByClassName( "delete" )[0]
		var author = document.getElementsByClassName( "author" )[0]
		var restrict = document.getElementsByClassName( "restrict" )[0]

		imaged.onclick = function() {

			var e = document.getElementById("sel1");
			var strUser = e.options[e.selectedIndex].value;
			document.location = "uploads/view.php?name=" + strUser + "&redirect=admin2.php"

		}

		deleted.onclick = function() {

			var e = document.getElementById("sel1");
			var strUser = e.options[e.selectedIndex].value;
			document.location = "admin2.php?action=delete&target=" + strUser

		}

		author.onclick = function() {
			var e = document.getElementById("sel1");
			var strUser = e.options[e.selectedIndex].value;
			document.location = "admin2.php?action=author&target=" + strUser

		}

		restrict.onclick = function() {

			var e = document.getElementById("sel1");
			var strUser = e.options[e.selectedIndex].value;
			var password = restrict.id;
			var val = restrict.innerHTML;

			if (val == "Restrict image to admins") {
				restrict2( true, strUser )
			}

			if (val == "Remove restrictions") {
				restrict2( false, strUser )
			}
		}
	}
}
setTimeout( ss, 2500 );
