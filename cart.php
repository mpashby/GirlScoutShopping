<?php
//Michele Pashby mpashby19@cmc.edu 30335753
// Represents the shopping cart for a single session.
class ShoppingCart {
	
    // List of products that is used to generate the HTML menu.
    public static $cookieTypes = Array("thinmints" => "Thin Mints",
                                       "samoas" => "Samoas",
                                       "trefoils" => "Trefoils",
                                       "lemoncreme" => "Lemon Chalet Cremes",
                                       "dosidos" => "Do-Si-Dos",
                                       "dulce" => "Dulce de Leche",
                                       "thanks" => "Thank U Berry Munch",
                                       "tagalongs" => "Tagalongs"
                                       );
	
    // The array that contains the order
    public $order;
	
    // Initially, the cart is empty
    public function __construct() {
        $this->order = Array();
    }
	
    // Adds an order to the shopping cart.  
    public function order($variety, $quantity) {
        if (isSet($this->order[$variety])) {
        $currentQuantity = $this->order[$variety];
      } else {
        $currentQuantity = 0;
      }
        $currentQuantity += $quantity;
        $this->order[$variety] = $currentQuantity;
    }
	
    // Display the order for debugging purposes.
    public function display() {
        print_r($this->order);
    }
}
?>