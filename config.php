<?php
$host ="10.100.102.31";
$user ="msduser";
$password ="Restrcted%RscMsd_23";
$dbname ="msd_db";
$con = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$con) {
	die('Connection failed.');

}

