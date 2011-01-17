<?php

require("db.php");

connectdb();

$arr = array();

// escape strings in post array
foreach ($_POST as $key => $value) {

	$arr[$key] = mysql_real_escape_string($value); 
} 

// insert data, escaped
insert($arr);

disconnectdb();

echo "ok";

?>
