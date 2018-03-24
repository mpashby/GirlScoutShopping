<?php 
//Michele Pashby mpashby19@cmc.edu 30335753
// Include the ShoppingCart class.  Since the session contains a
// ShoppingCart object, this must be done before session_start().
require "cart.php";
session_start(); 
?>

<!DOCTYPE html>

<?php 
// If this session is just beginning, store an empty ShoppingCart in it.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new ShoppingCart();
}
?>

<html lang="en">

<head>
<title>Girl Scout Cookie Shopping Cart</title>
<style>
.button1 {display: inline;}
</style>
</head>

<body>

<h2>Girl Scout Cookie Shopping Cart</h2>

<table>
	<form action='' method = "post">
  <tr><td> </td><td><b>Cookie</b></td><td><b>Quantity</b></td><td><b>Price</b></td><td><b>Edit</b></td></tr>

  <?php
  $cookies = Array("thinmints","samoas","trefoils","lemoncreme","dosidos","dulce","thanks","tagalongs");
  foreach($cookies as $key) {
 	if (isset($_POST[$key])) { //delete button pushed
 			unset($_SESSION['cart']->order[$key]); //remove from array
        }
  	if (isset ($_POST ["update"])) { //checks if form submitted
   		if(isset($_POST[$key."1"])) {//check if quantity box changed
   			update($key,($_POST[$key."1"])); //change quantity in array
          		}
 			}  
}
  	function properName($key){
  		return ShoppingCart::$cookieTypes[$key];
  	}

  	$totalPrice=0;
  	$totalCount=0;
  	function price($value){
  		$cPrice = $value *5;
  		global $totalPrice;
  		$totalPrice+= $cPrice;
  		global $totalCount;
  		$totalCount+= $value;
  		return $cPrice;	
  	}
 
  	function update($key,$value) {
  		unset($_SESSION['cart']->order[$key]); //delete old value, replace with new one
  		$_SESSION['cart']->order($key, $value);
  	}
  	function displayRow($key,$value) {
  		if ($value != 0) {  //quantity is not zero, display table row
  		return "<tr><td><img src ='".$key.".jpg'></p></td><td>".properName($key)."</td><td>".$value."</td><td>$".price($value)."</td><td><input type='text' name = ".$key."1 value=".$value."></td>
		<td><input type='submit' name='".$key."' value='Delete' ></td></tr>";
  		} 
   	}
  
	foreach ($_SESSION['cart']->order as $key=>$value) {
		echo displayRow($key,$value);
	}

	//last row
	echo "<tr><td></td><td><b>Total</b></td><td><b>".$totalCount."</b></td><td><b>$".$totalPrice."</b></td><td><input type='submit' value='Update Cart' name='update'></td></tr>";
	?>
</form>
</table> 

<form id = "button1" action="index4.php">
    <input type="submit" value="Resume Shopping" />
</form>
<form id = "button1" action="checkout.php">
    <input type="submit" value="Check Out" />
</form>

</body>
</html>
