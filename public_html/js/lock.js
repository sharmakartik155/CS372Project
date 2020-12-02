function updateTitle() {
	
}

function updateContent() {
	
}

function release(event) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "../snippets/release.php?requestor_id=" + requestor_id + "&doc_id=" + doc_id, true);
	xmlhttp.send();
	window.location = "http://www2.cs.uregina.ca/~soren200/pages/view.php?id=" + doc_id;
}


function request(event) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "../snippets/request.php?editor_id=" + editor_id + "&requestor_id=" + requestor_id + "&doc_id=" + doc_id, true);
	xmlhttp.send();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		}
	}
}

function saveDoc() { 

}

/*
var timerVar = setInterval(timer, 3000);

function timer(doc_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "../snippets/timer.php?doc_id=" + doc_id, true);
	xmlhttp.send();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var results = JSON.parse(this.responseText);
			alert(results[0].user_alias + " requested control.");
			//return results[0].user_id;
		}
	}
}*/