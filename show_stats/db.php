<?php

require("config.php");

function connectdb() {
	mysql_connect(DBSERVER, DBUSER, DBPW) or die('{"status":"error", "message": "CONNECT - ' . mysql_error() . '"}');
	mysql_select_db(DB) or die('{"status":"error", "message": "SELECT - ' . mysql_error() . '"}');
}

function disconnectdb() {
	mysql_close();
}

function get_app_list() {
   return mysql_query("SELECT DISTINCT appid FROM " . TABLE);
}

function by_app($appid) {

   // filter out a specific device and the emulator
   if ($filterUUID && $filterEmulator) {
      $query = "SELECT * FROM " . TABLE . " WHERE appid = '" . $appid . "' AND modelascii != 'Emulator' AND uuid != '" . MYUUID . "' ORDER BY lasthit DESC";
   }
   
   // filter out only the emulator
   else if ($filterEmulator) {
      $query = "SELECT * FROM " . TABLE . " WHERE appid = '" . $appid . "' AND modelascii != 'Emulator' ORDER BY lasthit DESC";
   }
   
   // filter out only a specific device
   else if ($filterUUID) {
      $query = "SELECT * FROM " . TABLE . " WHERE appid = '" . $appid . "' AND uuid != '" . MYUUID . "' ORDER BY lasthit DESC";
   }
   
   // don't filter the results
   else {
      $query = "SELECT * FROM " . TABLE . " WHERE appid = '" . $appid . "' ORDER BY lasthit DESC";
   }

   // returns all records for a particular app, but not the emulator or my device
   $result = mysql_query($query) or die('{"status": "error", "message": "QUERY - ' . mysql_error() . '"}');
   
   $i = 0;
   $return = array();

   // while there are records, get an associative array of the current record
   while ($row = mysql_fetch_assoc($result)) {

	   // copy the associative array of the record into the return array
	   $return[$i] = $row;

	   $i++;
   }
   
   return json_encode($return);
   
}

?>
