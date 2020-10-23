<?php
	if (isset($_GET['q'])) {
		
		$db = new mysqli("localhost", "", "", "");
		if ($db->connect_error)
		{
			die ("Connection failed: " . $db->connect_error);
		}
		
		$q1 = "SELECT * FROM message;";
		$r1 = $db->query($q1);
		
		$active_messages = 0;
		
		while($message_data = $r1->fetch_assoc()) {
			$active_messages++;
		}
		
		$q2 = "SELECT * FROM messageSeenBy;";
		$r2 = $db->query($q2);
		
		$message_views = 0;
		
		while($messageSeenBy_data = $r2->fetch_assoc()) {
			$message_views++;
		}
		$array[0] = array('active_messages' => $active_messages, 'message_views' => $message_views);
		
		$q3 = "SELECT * FROM user where logged_in = 'true';";
		$r3 = $db->query($q3);
		
		$i = 1;
		
		while($active_users = $r3->fetch_assoc()) {
			$array[$i] = $active_users;
			$i++;
		}
		
		echo json_encode($array);
	}
?>



	<script>
	//execute the timer function immediately
	timer();
	
	var timerVar = setInterval(timer, 120000);
	
	function timer() {
		var  xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", "assignment_timer.php?q=update", true);
		xmlhttp.send();
		
       // access the onreadystatechange event for the XMLHttpRequest object
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {	
				var results = JSON.parse(this.responseText);

				var result_length = results.length;

				if (result_length > 0) {
				document.getElementById("active_messages").innerHTML = results[0].active_messages;
				document.getElementById("message_views").innerHTML = results[0].message_views;
				}
			
			var active_users = "";
			//example of how to display things from JSON
			 for (var i = 1; i < result_length; i++) {
				active_users += "<div class=\"activeMessage\">";
				active_users += "<table class=\"box\">";
				active_users += "<tr>";
				active_users += "<td><img src=\""; active_users += results[i].avatar; active_users +="\" alt=\"placeholder\" class=\"avatar\" />";
				active_users += "<td>"; active_users += results[i].username; active_users += "</td>";
				active_users += "</tr>";
				active_users += "</table>";
				active_users += "</div>";
			 }
			document.getElementById("active_users").innerHTML = active_users;
			}
		}
	}
	</script>