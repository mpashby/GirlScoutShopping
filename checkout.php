<?php 
//Michele Pashby mpashby19@cmc.edu 30335753

// Include the ShoppingCart class.  
require "cart.php";
session_start(); 
?>

<!DOCTYPE html>

<?php 
// If this session is just beginning, store an empty ShoppingCart in it.

$firstname2=""; //error messages 
$lastname2=""; 
$address2="";
$city2="";
$state2="";
$zip2="";
$phone2="";
$email2="";
$girl2="";
$troup2="";
$fname="";
$addressValue = "";
$lname="";
$cityVal="";
$zipVal="";
$troupVal="";
$girlVal="";
$phoneVal="";
$emailVal="";
$stateVal="";
$check=false; 
$bill="";
if (!isSet($_SESSION['cart'])) {
    $_SESSION['cart'] = new ShoppingCart();
}	
if (isSet($_POST["submit"])) { //user has submitted 	
//validate fields non blank
if (isset($_POST['firstname'])) {  //validate firstname
  $fname = ($_POST['firstname']);
	if (($_POST['firstname'])=="") {
		$firstname2 = "First Name Missing";
	} else if (!ctype_alpha($_POST['firstname'])) {
		$firstname2 = "Not a valid first name";
	}
} 
if (isset($_POST['lastname'])) {  //vvalidate last name
  $lname=($_POST['lastname']);
	if (($_POST['lastname'])=="") {
		$lastname2 = "Last Name Missing";
	}else if (!ctype_alpha($_POST['lastname'])) {
		$lastname2 = "Not a valid last name";
	}
}
if (isset($_POST['address'])) {
  $addressValue = ($_POST['address']);
	if (($_POST['address'])=="") {
		$address2 = "Address Missing";
	}
}
if (isset($_POST['city'])) {
  $cityVal=($_POST['city']);
	if (($_POST['city'])=="") {
		$city2 = "City Missing";
	} else if (!ctype_alpha($_POST['city']) && ($_POST['city'])!=" "){
		$city2 = "Not a valid city";
	}

}
if (isset($_POST['state1'])) {
  $stateVal=($_POST['state1']);
	if (($_POST['state1'])=="") {
		$state2 = "State Missing";
	} else if (!ctype_alpha($_POST['state1'])) {
		$state2 = "Not a valid state";
	} 
 }  

if (isset($_POST['zip'])) {
  $zipVal=($_POST['zip']);
	if (($_POST['zip'])=="") {
		$zip2 = "Zip Code Missing";
	} else if ((! is_numeric($_POST['zip'])) || (strlen($_POST['zip']) !=5)) {  // 5 digit integer
		$zip2 = "Not a valid zip code";
	}
}
if (isset($_POST['phone'])) {
  $phoneVal=($_POST['phone']);
	if (($_POST['phone'])=="") {
		$phone2 = "Phone Number Missing";
	} else if ((! is_numeric($_POST['phone'])) || (strlen($_POST['phone']) !=10)) {
		$phone2 = "Not a valid phone number";
	}
}
if (isSet($_POST['email'])) {  //check e-mail
  $emailVal=($_POST['email']);
		if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email2 = "Not a valid e-mail";
		}
}	
if (isset($_POST['girl'])) {  //girl scout more than 3 letters and only alphabet
	$girlVal=($_POST['girl']);
  if ((ctype_alpha($_POST['girl'])==false) || (strlen($_POST['girl']) < 4)) {
			$girl2="Invalid Girl Scout";
	}
}
if (isset($_POST['troup'])) {
  $troupVal=($_POST['troup']);
	if (($_POST['troup'])=="") {
		$troup2 = "Troup Number Missing";
	} else if (! is_numeric($_POST['troup'])) {
		$troup2 = "Not a valid troup number";
	} 
}

if ($firstname2=="" && $lastname2=="" & $address2=="" && $city2=="" && $state2=="" && $zip2=="" && $phone2=="" && $email2=="" && $girl2=="" && $troup2=="") {
 // $bill="billing.php";
  $check2=true;
  $bill="billing.php";
}
  
}
?>

<html lang="en">

<head>
<title>Checkout</title>
<style>
  .error {display: inline; color: red;}
</style>

<script>
function validateForm() {  //Java script validation
    var x = document.forms["form1"]["firstname"].value;
    if (x == "") {
        document.getElementById("firstname2").innerHTML = "First Name is Missing";
    }
    var l = document.forms["form1"]["lastname"].value;
    if (l == "") {
        document.getElementById("lastname2").innerHTML = "Last Name is Missing";
    } 
    var adr = document.forms["form1"]["address"].value;
    if (adr == "") {
        document.getElementById("address2").innerHTML = "Address Missing";
    } 

    var ci = document.forms["form1"]["city"].value;
    if (ci == "") {
        document.getElementById("city2").innerHTML = "City Missing";
    } 
    else if (!isNaN(ci)) {
    	document.getElementById("city2").innerHTML = "Invalid City";
    }
    var st = document.forms["form1"]["state"].value;
    if (st == ""){
        document.getElementById("state2").innerHTML = "State Missing";
    } else if (!isNaN(st)) {
    	document.getElementById("state2").innerHTML = "Invalid State";
    }
    var zc = document.forms["form1"]["zip"].value;
    if (zc == ""){
        document.getElementById("zip2").innerHTML = "Zip Code Missing";
    } else if (isNaN(zc)) {
    	document.getElementById("zip2").innerHTML = "Invalid Zipcode";
    }
    var em = document.forms["form1"]["email"].value;
    if (em == ""){
    	document.getElementById("email2").innerHTML = "E-mail Missing";
    }
}

    function suggestState(str) {  //ajax state suggestion
    	if (str.length==0) {
    		document.getElementById("hint").innerHTML="";
    		return;
    	} else {
        var xmlhttp = new XMLHttpRequest();
    	  xmlhttp.onreadystatechange = function() {
   	 		if (this.readyState == 4 && this.status == 200) {
     			document.getElementById("hint").innerHTML = this.responseText;
   	 		}
 	  	}
 		xmlhttp.open("GET", "getState.php?q="+ str, true);
  	xmlhttp.send(); 
     
	}

  }
	
</script>	
</head>
<body>

<h2>Checkout</h2>

<p><b>Review Your Order Summary</b>
	<table>
  <tr><td><b>Cookie</b></td><td><b>Quantity</b></td><td><b>Price</b></td></tr>
	<?php
	$totalPrice=0;
	$totalCount=0;
	function properName($key){
  		return ShoppingCart::$cookieTypes[$key];
  	}
  	function price($value){
  		$cPrice = $value * 5;
  		global $totalCount;
  		$totalCount += $value;
  		global $totalPrice;
  		$totalPrice += $cPrice;
  		return $cPrice; 		
  	}
	foreach ($_SESSION['cart']->order as $key=>$value) {
		echo "<tr><td>".properName($key)."</td><td>".$value."</td><td>$".price($value);
	}
	echo "<tr><td><b>Total</b></td><td>".$totalCount."</td><td>$".$totalPrice."</td></tr>";	
	?>	
</table>
<a href="viewcart.php">Update Your Order</a>

</p>

<p><b>Customer Information</b></p>

<form id="form1" action= "<?php echo "$bill" ?>" onsubmit="return validateForm()" method="post">	
  First Name: 
  <input type="text" name="firstname" value = "<?php echo "$fname" ?>" required><p class="error" id="firstname2"> <?php echo "$firstname2" ?></p><br>
  Last Name: 
  <input type="text" name="lastname" value = "<?php echo "$lname" ?>" required><p class="error" id="lastname2"> <?php echo "$lastname2" ?></p><br>
  Street Address:
  <input type="text" name="address" value = "<?php echo "$addressValue" ?>" required><p class="error" id="address2"><?php echo "$address2" ?></p><br>
  City:
  <input type="text" name="city" value = "<?php echo "$cityVal" ?>" required><p class="error" id="city2"><?php echo "$city2" ?></p><br>
  State:
  <input type="text" name="state1" onkeyup="javascript:suggestState(this.value)" value = "<?php echo "$stateVal" ?>" required> <p class="error" id="state2"><?php echo "$state2" ?></p><br>
  <p>State Suggestions: <span id="hint"> </span></p>
  Zip Code:
  <input type="text" name="zip" value = "<?php echo "$zipVal" ?>" required><p class="error" id="zip2"><?php echo "$zip2" ?></p><br>
  E-Mail:
  <input type="email" name="email" value = "<?php echo "$emailVal" ?>" required>  
  		<p class="error" id="email2"><?php echo "$email2" ?></p><br>
  Phone Number <i>XXXXXXXXXX</i>:
  <input type="text" name="phone" value = "<?php echo "$phoneVal" ?>" required><p class = "error" id="phone2"><?php echo "$phone2" ?></p><br>

  <p><b>Girl Scout Information</b></p>
 	Name of Girl Scout:
	<input type="text" name="girl" value = "<?php echo "$girlVal" ?>" required><p class="error" id="girl2"> <?php echo "$girl2" ?> </p><br>
	Troup Number:
	<input type="text" name="troup" value = "<?php echo "$troupVal" ?>" required><p class="error" id="troup2"> <?php echo "$troup2" ?></p><br><br>
	<input type="submit" value="Submit" name = "submit">
</form>

<p><a href="index4.php">Shop some more!</a></p>

</body>
</html>