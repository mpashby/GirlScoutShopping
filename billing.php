<?php 
//Michele Pashby mpashby19@cmc.edu 30335753
// Include the ShoppingCart class.  Since the session contains a
// ShoppingCart object, this must be done before session_start().
require "cart.php";
session_start(); 
session_unset();  // remove all session variables
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Transaction Complete</title>
</head>
<body>
<h1>Transaction Complete</h1>
<p>Your credit card will be billed.  Thanks for the order!</p>
<p><a href="index4.php" >Purchase More</a></p>
<p>Learn More About <a href = "http://www.girlscouts.org/">Girl Scouts of America</a></p>

</body>
</html>