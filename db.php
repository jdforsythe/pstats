<?php

define("DBSERVER", "localhost");
define("DBUSER", "kcsw4drv_palmapp");
define("DBPW", "Olivia1001");
define("DB", "kcsw4drv_appaccess");
define("TABLE", "pstats");

function connectdb() {
	mysql_connect(DBSERVER, DBUSER, DBPW) or die("Connect Error: " . mysql_error());
	mysql_select_db(DB) or die("Select DB Error: " . mysql_error());
}

function disconnectdb() {
	mysql_close();
}

function insert($arr) {

	// see if the uuid already exists with the same app id (user already has used this app)
	$query = "SELECT hits FROM " . TABLE . " WHERE uuid = '" . $arr['uuid'] . "' AND appid = '" . $arr['appid'] . "' LIMIT 1";
	$result = mysql_query($query) or die("Error Checking uuid: " . mysql_error());

	if (mysql_num_rows($result) < 1) {
		// no record exists for this uuid and this app, so insert a new record

		$query = "INSERT INTO " . TABLE . " (appid, appver, webkitver, osbld, model, modelascii, osver, osvermj, osvermn, osverdt, carrier, width, height, locale, uuid, hits, firstuse) VALUES('" . $arr['appid'] . "', '" . $arr['appver'] . "', '" . $arr['webkitver'] . "', '" . $arr['osbld'] . "', '" . $arr['model'] . "', '" . $arr['modelascii'] . "', '" . $arr['osver'] . "', '" . $arr['osvermj'] . "', '" . $arr['osvermn'] . "', '" . $arr['osverdt'] . "', '" . $arr['carrier'] . "', '" . $arr['width'] . "', '" . $arr['height'] . "', '" . $arr['locale'] . "', '" . $arr['uuid'] . "', '1', NOW())"; // '1' hit, first use is NOW()

		mysql_query($query) or die("Error Inserting: " . mysql_error());
	}

	else {
		// there is already a record, so update it
		$row = mysql_fetch_row($result);
		$hits = $row[0] + 1;

		$query = "UPDATE " . TABLE . " SET appver='" . $arr['appver'] . "', webkitver='" . $arr['webkitver'] . "', osbld='" . $arr['osbld'] . "', model='" . $arr['model'] . "', modelascii='" . $arr['modelascii'] . "', osver='" . $arr['osver'] . "', osvermj='" . $arr['osvermj'] . "', osvermn='" . $arr['osvermn'] . "', osverdt='" . $arr['osverdt'] . "', carrier='" . $arr['carrier'] . "', width='" . $arr['width'] . "', height='" . $arr['height'] . "', locale='" . $arr['locale'] . "', hits='$hits' WHERE uuid = '" . $arr['uuid'] . "' AND appid = '" . $arr['appid'] . "' LIMIT 1";

		mysql_query($query) or die("Error updating: " . mysql_error());
	}

}

?>
