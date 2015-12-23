function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
} // Thanks to http://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit (Rakesh Pai and Liam)

function getUP( u ) {
	if (u) {
		if (u.search(",") !== false) {
			return true
		} else {
			return false
		}
	}
}

function images() {
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
setInterval( images, 500 );

function restrict2( restrictType, target ) {
	var restrict = document.getElementsByClassName( "restrict" )[0]
	var password = getUP( restrict.id );
	var userControl = false;
	var user = "";
	var pass = "";
	if (password) {
		var password = restrict.id;
		var spl = password.split( "," )
		user = spl[0]
		pass = spl[1]
		userControl = true;
	}
	if (restrictType == true) {
		if (userControl) {
			post( "admin2.php?action=restrict&target=" + target, { username: user, password: pass })
		} else {
			post( "admin2.php?action=restrict&target=" + target, { username: restrict.id } )
		}
	} else {
		if (userControl) {
			post( "admin2.php?action=remover&target=" + target, { username: user, password: pass })
		} else {
			post( "admin2.php?action=remover&target=" + target, { username: restrict.id } )
		}
	}
}

function ss() {
	var imaged = document.getElementsByClassName( "imaged" )[0]
	var deleted = document.getElementsByClassName( "delete" )[0]
	var author = document.getElementsByClassName( "author" )[0]
	var restrict = document.getElementsByClassName( "restrict" )[0]
	imaged.onclick = function() {
		var e = document.getElementById("sel1");
		var strUser = e.options[e.selectedIndex].value;
		var password = getUP( imaged.id );
		if (password) {
			var password = imaged.id;
			var spl = password.split( "," )
			var user = spl[0]
			var pass2 = spl[1]
			alert( user + "," + pass2 )
			post( "uploads/view.php?name=" + strUser + "&redirect=admin2.php", { username: user, pass: pass2 } ); 
		} else {
			alert( imaged.id )
			post( "uploads/view.php?name=" + strUser + "&redirect=admin2.php", { username: imaged.id } );
		}
	}
	deleted.onclick = function() {
		var e = document.getElementById("sel1");
		var strUser = e.options[e.selectedIndex].value;
		var password = getUP( deleted.id );
		if (password) {
			var password = deleted.id;
			var spl = password.split( "," )
			var user = spl[0]
			var pass = spl[1]
			post ( "admin2.php?action=delete&target=" + strUser, { username: user, password: pass } )
		} else if (password == false) {
			var password = deleted.id;
			post ( "admin2.php?action=delete&target=" + strUser, { username: password } )
		}
	}
	author.onclick = function() {
		var e = document.getElementById("sel1");
		var strUser = e.options[e.selectedIndex].value;
		var password = author.id;
		var authorname = prompt("Please enter a proper author name", "Anonymous");
		var password2 = getUP( author.id );
		if (password2) {
			var spl = password.split( "," )
			var user = spl[0]
			var pass = spl[1]
			post("admin2.php?action=author&target=" + strUser + "&authorname=" + authorname, { username: user, password: pass  } )
		} else {
			post( "admin2.php?action=author&target=" + strUser + "&authorname=" + authorname, { username: password } )
		}
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
setTimeout( ss, 2500 );
