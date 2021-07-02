<?php
require "./src/mysql.php";
require "./src/constants.php";

$mysql = new MySQL(DB_HOSTNAME, DB_USER, DB_PASSWORD, DB_DATABASE);
