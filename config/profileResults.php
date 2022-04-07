<?php
//C.H Database connection for prop results
//Create connection and select DB
require_once "../config/.config.php";

session_start();
//test to show email from tenant 
$validation = $db->query("SELECT * FROM Landlord WHERE Email = 'acartmell0@loc.gov'"); 
 
echo $_POST;
?>