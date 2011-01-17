<?php

require("db.php");

$func = $_POST['func'];
$param = $_POST['param'];


switch ($func) {

   case "by_app":
      connectdb();
      echo by_app($param);
      disconnectdb();
   break;
   
   default:
      echo '{"status":"error", "message": "incorrect call to results.php"}';
   break;
   
}

?>
