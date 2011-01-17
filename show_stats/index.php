<!DOCTYPE html>
<html>
<head>
   <script type="text/javascript">
   var contentDiv;
   
   function init() {
      contentDiv = document.getElementById("content");
   }
   
   function get_results(func, param) {

		xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
		
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

				// create an object and parse the JSON string returned from the server into that object
				var response = JSON.parse(xmlhttp.responseText);

				// {"status":"error", "message":"PHP error message"}
				// check if it's defined because a successful response will not have a response.status
				if (response.status !== undefined && response.status === "error") {
				   alert("error");
					contentDiv.innerHTML = "<h2>There has been an error</h2><p>" + response.message + "</p>";
				}

				// otherwise we have a successful status and records were returned
				else {
					show_results(response);
				}

			}

		}; // xmlhttp.onreadystatechange = function() {


		// url to make the request to
		var url = "results.php";

		// POST parameters (formatted just like a GET request is in the URL - "key1=value1&key2=value2&...&keyn=valuen")
		// the encodeURIComponent() function URI-encodes the query so any punctuation and spaces are escaped
		var params = "func=" + func + "&param=" + param;

		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(params);

	} // function do_select_query()
	
	function show_results(response) {
	
	   var i,record,html;
	   html = "<table border=2>" +
	            "<tr><th>appid</th><th>appver</th><th>model</th><th>osver</th><th>carrier</th><th>locale</th><th>hits</th><th>lasthit</th><th>firstuse</th></tr>";

	   for (i=0; i<response.length; i++) {
	      record = response[i];
	   
	      html += "<tr><td>" + record.appid + "</td>" +
	              "<td>" + record.appver + "</td>" +
	              "<td>" + record.modelascii + "</td>" +
	              "<td>" + record.osver + "</td>" +
	              "<td>" + record.carrier + "</td>" +
	              "<td>" + record.locale + "</td>" +
	              "<td>" + record.hits + "</td>" +
	              "<td>" + record.lasthit + "</td>" +
	              "<td>" + record.firstuse + "</td></tr>";
	   }
	   
	   html += "</table>";
	   
	   contentDiv.innerHTML = html;
	   
	};
	
	</script>
	
	<title>Palm App Stats</title>
	
</head>

<body onload="init();">

   <h1>Palm App Stats</h1>
   
   <div id="appList">
      <ul>
         <?php
            require("db.php");
            
            connectdb();
            
            $result = get_app_list();
            
            while ($apps = mysql_fetch_assoc($result)) {
            
               echo '<li><a href="#" onclick="get_results(\'by_app\', \'' . $apps['appid'] . '\');">' . $apps['appid'] . '</a></li>';
               
            }
            
            disconnectdb();
         ?>
      </ul>
   </div>
   
   <div id="content">
      <p>Results here...</p>
   </div>
   
</body>
</html>
