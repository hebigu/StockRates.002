<?php

// Paypal Encrypted buttons vs. Developer buttons
// We have an inhouse shopping cart, therefore we use developer buttons
// This method with developer buttons can an offer for price-jacking Biotch!!!
// We are using ipn, so we can check out/in values
// To avoid someone reading information in return message to ipn, we vill use ssl
// The  content of file .htaccess insure https prefix

session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 

 $stockMessage = "";  
 $sql1 = "";

if (isset($_POST['pid'])) AddToCartFromProduct();
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") EmptyCart();
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") AdjustItemQuantity();
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "")  RemoveItemFromCart();

function AddToCartFromProduct()
{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user attempts to add something to the cart from the product page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
	    // RUN IF THE CART IS EMPTY OR NOT SET
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	} else {
		// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
		foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
	       } // close foreach loop
		   if ($wasFound == false) {
			   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		   }
	}
	header("location: cart.php"); 
    exit();

}
 
function EmptyCart()
{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    unset($_SESSION["cart_array"]);
}

function AdjustItemQuantity()
{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$item_to_adjust = $_POST['item_to_adjust']; 
	$quantity = $_POST['quant'];
        
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  } // close if condition
		      } // close while loop
	} // close foreach loop
}

 
function RemoveItemFromCart()
{
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$shipment = "";
$shipment = money_format("%10.2n", 25);
$vatTotal = "";
$total = "";
$cartTotal = "";
$pp_checkout_btn = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Din indkøbskurv er tom</h2>";
    $shipment = 0;
} else {
	// Start PayPal Checkout Button
	//$pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        $pp_checkout_btn .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="hebigu@gmail.com">';
	// Start the For Each loop
	$i = 0; 
  
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM products WHERE id='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name = $row["product_name"];
			$price =  $row["price"];
			$details =  $row["details"];  
                        $on_stock = $row["on_stock"];  
                        
                        if ($each_item['quantity'] > $on_stock)
                        {
                           $each_item['quantity'] = $on_stock;
                           $stockMessage = "Det antal du har ønsket, er desværre ikke på lager, derfor er antallet justeret efter vores lagersituation.";
                        }

                        
		}
                

                
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		// setlocale(LC_MONETARY, "en_US");
                setlocale (LC_ALL, "da_DK.ISO8859-1");
               // $pricetotal = money_format("%10.0n", $pricetotal);
                
                
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;
                $shipment2 = 0;
               
		$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">';
                $pp_checkout_btn .= '<input type="hidden" name="amount_' . $x . '" value="' . $price . '">';
                $pp_checkout_btn .= '<input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">'; 
                if  ($x==1)
                {
                    $shipment = 25 +  2 * ($each_item['quantity'] - 1);
                    $pp_checkout_btn .= '<input type="hidden" name="shipping_' . $x . '" value="' . $shipment . '"> ';
                }
                else
                {
                    $shipment2 = 2 * $each_item['quantity'];
                    $shipment =  $shipment + $shipment2;
                    $pp_checkout_btn .= '<input type="hidden" name="shipping_' . $x . '" value="' . $shipment2 . '"> ';
                }
                
                $vatTotal = money_format("%10.2n",($cartTotal + $shipment)/125*25);
                $total = $cartTotal + $shipment;
                
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].","; 
		// Dynamic table row assembly
		$cartOutput .= '<tr class="item">';
		$cartOutput .= '<td align=right><a href="product.php?id=' . $item_id . '">' . $product_name . '</a><br /><img src="inventory_images/' . $item_id . '.jpg" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
		$cartOutput .= '<td align=right>' . $details . '</td>';
		$cartOutput .= '<td align=right>' . $price . '</td>';
                
                //Herunder erstattes med javascript
		$cartOutput .= '<td class="jss_qty" align=right><form name="submitting" id="submitting" action="cart.php" method="post">
		<input name="quantity" type="text" onKeyup=updateQuantities(this,'.$item_id.') value="' . $each_item['quantity'] . '" size="1" maxlength="2" /> 
                <input name="item_to_adjust" id="item_to_adjust" type="hidden" value="'.$item_id.'" />
                <input name="quant" id="quant" type="hidden" value="'. $each_item['quantity'] .'" />
		</form></td>';
                
		$cartOutput .= '<td align=right>' . $pricetotal . '</td>';
		$cartOutput .= '<td align=right><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="Slet" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
		$cartOutput .= '</tr>';
		$i++; 
                
                $currentDateTime = date('Y-m-d H:i:s');
                $quantity = $each_item['quantity'];
                
               // $sql1 .=  "INSERT INTO pending_transactions (product_id, quantity, date) VALUES('$item_id','$quantity','$currentDateTime');";

              //  echo $sql1;
                
                
    } 
    
        
	setlocale (LC_ALL, "da_DK.ISO8859-1");

        // Finish the Paypal Checkout Btn
	$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	<input type="hidden" name="notify_url" value="https://www.bigumsoft.dk/Test/OnlineStore/storescripts/my_ipn.php">
	<input type="hidden" name="return" value="https://www.bigumsoft.dk/Test/OnlineStore/checkout_complete.php">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Retur til Bigumsoft OnlineStore">
	<input type="hidden" name="cancel_return" value="https://www.bigumsoft.dk/Test/OnlineStore/paypal_cancel.php">
	<input type="hidden" name="lc" value="DK">
	<input type="hidden" name="currency_code" value="DKK">
	<input type="image" src="https://www.paypalobjects.com/da_DK/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal – den sikre og nemme måde at betale på nettet.">
	</form>';
        
}

?>



<script type="text/JavaScript">
    
function updateQuantities(box_quantity,id)
{ 
   var item_to_adjust = document.getElementById("item_to_adjust");
   item_to_adjust.value = id;

   var quant = document.getElementById("quant");
   
   quant.value = box_quantity.value;
    
   document.forms["submitting"].submit();
}
</script>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Indkøbskurv</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
	
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td  align=right width="16%" bgcolor="#C5DFFA"><strong>Produkt</strong></td>
        <td  align=right width="40%" bgcolor="#C5DFFA"><strong>Produkt beskrivelse</strong></td>
        <td  align=right width="10%" bgcolor="#C5DFFA"><strong>Enhedspris DKK</strong></td>
        <td  align=right width="14%" bgcolor="#C5DFFA"><strong>Antal</strong></td>
        <td  align=right width=11%" bgcolor="#C5DFFA"><strong>Total DKK</strong></td>
        <td  align=right width="9%" bgcolor="#C5DFFA"><strong>Slet række</strong></td>
      </tr>
     <?php echo $cartOutput; ?> 
    </table>
    
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width=80%"><strong>Indkøbskurv total</strong>&nbsp;</td>
        <?php echo '<td align=right width=11%"><strong>'.$cartTotal.'</strong>&nbsp;</td>'; ?> 
        <td width="9%" bgcolor="#A4A4A4">&nbsp;</td>
      </tr>
      <tr>
        <td width=80%"><strong>Forsendelse og håndtering</strong>&nbsp;</td>
        <?php 
            if ($shipment==0) $shipment = "";
            echo '<td align=right width=11%"><strong>'.$shipment.'</strong>&nbsp;</td>'; 
        ?> 
        <td width="9%" bgcolor="#A4A4A4">&nbsp;</td>
      </tr>
      <tr>
        <td width=80%"><strong>Total pris inkl. forsendelse og moms</strong>&nbsp;</td>
        <?php echo '<td  align=right width=11%"><strong>'.$total.'</strong>&nbsp;</td>'; ?> 
        <td width="9%" bgcolor="#A4A4A4">&nbsp;</td>
      </tr>
      <tr>
        <td width=80%"><strong>Heraf moms</strong>&nbsp;</td>
        <?php 
            if (!isset($vatTotal))
                {
                    echo '<td align=right width=11%"><strong>'.money_format("%.2n", $vatTotal).'</strong>&nbsp;</td>'; 
                }
                else 
                {
                    echo '<td align=right width=11%"><strong>'.$vatTotal.'</strong>&nbsp;</td>'; 
                }   
        ?> 
        <td width="9%" bgcolor="#A4A4A4">&nbsp;</td>
      </tr>
        
    </table>
        
    <?php
    
        echo '<div> <font size="3" color="red">'.$stockMessage.'</font></div>'; 
    
      //  echo  '<div> <font size="2" >'.$sql1.'</font></div>'; 
        
    ?>
    
    <br />
<br />
    <?php 
         echo $pp_checkout_btn; 
    ?>
    <br />
    <br />
    <a href="cart.php?cmd=emptycart">Klik her for at tømme din kurv</a>
    </div>
   <br />
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>


