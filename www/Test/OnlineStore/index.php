<?php 

// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php 
// Run a select query to get my letest 6 items
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 
$dynamicList = "";
$sql = mysql_query("SELECT * FROM products WHERE on_stock > 0  ORDER BY date_added DESC LIMIT 6");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
             $id = $row["id"];
			 $product_name = $row["product_name"];
			 $price = $row["price"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			 $dynamicList .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
          <td width="17%" valign="top"><a href="product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
          <td width="83%" valign="top">' . $product_name . '<br />
            ' . $price . ' DKK<br />
            <a href="product.php?id=' . $id . '">Se produktdetaljer</a></td>
        </tr>
      </table>';
    }
} else {
	$dynamicList = "Vi har desværre ikke nogen produkter på lager, kom tilbage på et senere tidspunkt";
}
mysql_close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Produktoversigt</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
  <table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="32%" valign="top"><h3>Om Bigumsoft</h3>
      <p>BEMÆRK venligst at webshoppen er under udvikling og altså ikke åbnet endnu, men derfor er du velkommen til at teste og give feedback.<br />
         </p>
       <p>
         </p><br /> 
      <p>BigumSoft er en virksomhed, som primært beskæftiger sig med udvikling af software.<br />
         </p>
       <p>Ved siden af udvikling af software, driver vi en lille forretning med salg af (specielle) postkort etc.<br />
         </p>
         <p><br />
         </p>
         <p><br />
         </p>
         <p>Siderne kræver javascript, til gengæld bruger vi ikke cookies.<br />
         </p>
      <p><br />
        <br />
        </p></td>
    <td width="35%" valign="top"><h3>Eksempler på postkort</h3>
      <p><?php echo $dynamicList; ?><br />
        </p>
      <p><br />
      </p></td>
    <td width="33%" valign="top"><h3>Bestilling</h3>
      <p>Bestiller du postkort hos os, anbefaler vi at du køber mere end et, da minimum forsendelsesomkostninger tit løber op uhensigtsmæssigt.</p></td>
  </tr>
</table>

  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>