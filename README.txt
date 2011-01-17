pstats
Palm webOS app stats framework

Requirements:
-------------
1) A web server with PHP installed
2) A mySQL server
3) A mySQL user with INSERT, UPDATE, and SELECT access
4) The ability to import a table structure into a database (phpMyAdmin makes this easy!)
5) At least one webOS app to track with pstats

Instructions:
-------------
1) Edit the table.sql file (if you want) to change the table name to reflect what you want your table called. The line you need to change is:
   CREATE TABLE IF NOT EXISTS `pstats` (
   (change pstats to whatever table name you desire)
   
2) Edit the config.php file and follow the instructions to set your mySQL database connection information. Be sure to use the same table name you put in table.sql and remember the database name you put here.

3) Log on to your mySQL server and create/select a database for the stats to be stored in (must be the same name that's defined in config.php). Import the table.sql file to create the table for pstats.
   - if you're using phpMyAdmin, just pick a database from the left sidebar (or create a new one) and then choose "Import" from the top navigation tabs. Pick the table.sql file to import the structure.

4) Upload the *.php files to your web server. Make a note of the path to the files.
   - config.php
   - db.php
   - save.php
   
5) Add pstats to your app. Copy the pstats.js file to your app directory (or a subfolder). Include this in your index.html file (after the inclusion of Mojo) or in sources.json.
   - <script type="text/javascript" src="pstats.js"></script>
   
6) Invoke pstats in your app. Open path_to_app/app/assistants/stage-assistant.js
   - in the stage assistant setup method:
   
   StageAssistant.prototype.setup = function() {
	   // use pstats stat tracking framework
	   var stats = new pstats();
	   stats.send("http://www.mysite.com/pstats/save.php");
   };  

   - change the "http://www.mysite.com/pstats/save.php" to the path to save.php on your web server
   
That's all there is to it! To add this to other apps, simply repeat steps 5 and 6. The data for all your apps will be stored in a single table in your database. (Although you could potentially create a different database and/or table for each app, but this is not necessary)


Reading the data:
-----------------

I'm working on a good interface (for the web and an app for your phone) to read the data. For the time being, you can upload the files in the show_stats folder to your web server (after editing the items in config.php) and view the stats by pointing your web browser to http://www.mysite.com/pstats/show_stats/index.php (or whatever path you choose). This will bring up a list of all the apps that have entries in your table. Clicking on the appid will display a table of the most important data from the table.

If you want to filter out emulator hits from your results, simply change the line in /show_stats/config.php to read $filterEmulator = true;

If you want to filter out hits from your device in the results, change the line in /show_stats/config.php to read $filterUUID = true; and uncomment the DEFINE statement for UUID and put your device's UUID in. To get your device's uuid test the app once with this turned off and check for the entry. Copy and paste the uuid from the results into /show_stats/config.php. Now your uses will no longer show up in the results table.
