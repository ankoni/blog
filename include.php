<?php
include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini'); //data of db

//connect to db
$blog = new WorkDB($config);