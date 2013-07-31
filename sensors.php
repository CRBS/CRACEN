<?php 
// Connects to database 

mysql_connect("localhost.ucsd.edu", "root", "password") or die(mysql_error());
mysql_select_db("temp_air") or die(mysql_error()); 

mysql_query("INSERT INTO temp_air(Air Flow, Celsius, Fahrenheit) VALUES ($airFlow_Value, $tempC, $tempF)");

// next print command is for debugging by suffixing data to the url to test it on its wwn

Print "Your table has been populated"; 
?>
