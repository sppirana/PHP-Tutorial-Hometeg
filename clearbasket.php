<?php
session_start();
include("db.php");

$pagename = "Clear Smart Basket";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>".$pagename."</title>";
echo "<body>";
include("headfile.html");
echo "<h4>".$pagename."</h4>";

// Clear the basket session array
unset($_SESSION['basket']);
echo "<p>Your basket has been cleared!";

// Provide a link back to the basket page
echo "<p><a href='basket.php'>Return to Basket</a></p>";

include("footfile.html");
echo "</body>";
?>