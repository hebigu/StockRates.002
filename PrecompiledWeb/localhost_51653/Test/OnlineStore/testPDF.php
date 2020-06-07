<?php

//session_start(); // Start session first thing in script
// Script Error Reporting
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 

require('pdf/fpdf.php');
define('FPDF_FONTPATH','pdf/font/');


class PDF extends FPDF
{
    function Header()
    {
        global $title;
        global $titleHeight;
        global $titleBorder;
        global $logoPath;
        global $logoLeft;
        global $logoDown;
        global $logoSize;

        // Logo
        $this->Image($logoPath,$logoLeft,$logoDown,$logoSize);
        $this->Ln(10);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title)+6;
        $this->SetX((210-$w)/2);

        // Thickness of frame (1 mm)
        $this->SetLineWidth(0.3);
        // Title
        $this->Cell($w,$titleHeight,$title,$titleBorder,1,'C',false);

        $this->SetLineWidth(0.2);
        $this->Line(2,40,200,40);
        $this->Ln(12);
    }


    
    function InfoToCustomer($customerName, $orderNumber)
    {
        $this->SetFont('Arial','',10);

        $someText = iconv("UTF-8", "ISO-8859-1", "Kære " . $customerName);
        $this->Text(2,45,$someText);

        $someText = iconv("UTF-8", "ISO-8859-1", "For en god ordens skyld kan vi hermed bekræfte, at din ordre, med nummer " . $orderNumber . ", pakkes og afsendes snarest muligt.");

        $this->Text(2,53,$someText);

        $this->SetFont('Arial','B',12);
        $someText = "Dine oplysninger";
        $this->Text(80,67,$someText);          
    }

    function CustomerOrderInformation($customerKeys, $customerInformation, $orderKeys, $orderInformation)
    {
           $this->SetFont('Arial','B',9);
           $this->SetY(69);
           $this->SetX(20);
           $this->Cell(70, 5, 'Kundeoplysninger', 1, 0, 'L');
           $this->Cell(70, 5, 'Bestillingsoplysninger', 1, 1, 'L');

           $this->SetFont('Arial','',9);
           $this->SetY(74);
           $this->SetX(20);

           $this->Multicell(30,5,$customerKeys, 0, 'L');

           $this->SetY(74);
           $this->SetX(50);

           $this->MultiCell(40,5,$customerInformation,0,'L');   

           $this->SetY(74);
           $this->SetX(90);

           $this->MultiCell(30,5,$orderKeys,0,'L');   

           $this->SetY(74);
           $this->SetX(120);

           $this->MultiCell(40,5,$orderInformation,0,'L');   

           $this->Line(20,69,20,105);
           $this->Line(90,69,90,105);
           $this->Line(160,69,160,105);

           $this->Line(20,105,160,105); // nederste horisontale linie
    }

    function OrderLines($orders, $shipping, $total, $vatTotal)
    {
            $this->SetFont('Arial','B',9);

            $this->SetY(106);
            $this->SetX(20);                

            $this->Cell(25, 5, 'Varenummer', 1, 0, 'L');
            $this->Cell(73, 5, 'Betegnelse', 1, 0, 'L');
            $this->Cell(12, 5, iconv("UTF-8", "ISO-8859-1","Beløb"), 1, 0, 'L');
            $this->Cell(10, 5, 'Antal', 1, 0, 'L');
            $this->Cell(20, 5, iconv("UTF-8", "ISO-8859-1","Total beløb"), 1, 1, 'L');

            $product_ids = "";
            $product_quantitys = "";
            $rowprices = "";
            $prices = "";

            $subtotal = 0;

            $id_str_array = explode(",", $orders); // Uses Comma(,) as delimiter(break point)

            foreach ($id_str_array as $key => $value) 
                {
                   $id_quantity_pair = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
                   $product_id = $id_quantity_pair[0]; // Get the product ID
                   $product_quantity = $id_quantity_pair[1]; // Get the quantity     

                   if (isset($product_quantity))
                   {
                           $sql = mysql_query("SELECT * FROM products WHERE id='$product_id' LIMIT 1");
                           while ($row = mysql_fetch_array($sql)) 
                           {
                                   $product_ids .= $product_id."\n";

                                   $product_name .= $row["product_name"]."\n";
                                   $price =  $row["price"];
                                   $details =  $row["details"];  

                                   $prices .= $price." kr.\n";

                                   $rowprice = $price * $product_quantity;
                                   $subtotal = $subtotal + $rowprice;

                                   $product_quantitys .= $product_quantity."\n";
                                   $rowprices .= $rowprice." kr.\n";
                           }             
                   }
              }

         $this->SetFont('Arial','',9);
         $this->SetY(111);
         $this->SetX(20);
         $this->MultiCell(25,5,$product_ids,'LTB','R'); 

         $this->SetY(111);
         $this->SetX(45);
         $this->MultiCell(73,5,$product_name,'LT','L');  

         $this->SetY(111);
         $this->SetX(118);
         $this->MultiCell(12,5,$prices,'LT','R');  

         $this->SetY(111);
         $this->SetX(130);    
         $this->MultiCell(10,5,$product_quantitys,'LRT','R');

         $this->SetY(111);
         $this->SetX(140);     
         $this->MultiCell(20,5,$rowprices,1,'R');

         //Subtotal
         $this->SetX(45);
         //$this->SetFont('Arial','',9);
         $this->Cell(95, 5, 'Subtotal', 1, 0, 'L');
         $this->Cell(20, 5, $subtotal." kr.", 1, 1, 'R');
         
         //Shipping
         $this->SetX(45);
         //$this->SetFont('Arial','',9);
         $this->Cell(95, 5, iconv("UTF-8", "ISO-8859-1","Forsendelse og håndtering"), 1, 0, 'L');
         $this->Cell(20, 5, $shipping." kr.", 1, 1, 'R');
         
         
         //Total
         $this->SetFont('Arial','B',9);
         $this->SetX(45);
         //$this->SetFont('Arial','',9);
         $this->Cell(95, 5, iconv("UTF-8", "ISO-8859-1","Total beløb"), 1, 0, 'L');
         $this->Cell(20, 5, $total." kr.", 1, 1, 'R');
         
         //VAT
         $this->SetFont('Arial','I',9);
         $this->SetX(45);
         $this->Cell(95, 5, "Heraf moms", 1, 0, 'L');
         $this->Cell(20, 5, $vatTotal." kr.", 1, 1, 'R');
         
         

////         $vatTotal = money_format("%10.2n",$subtotal/125*25);
////         $vatTotal = str_replace(".", ",", $vatTotal);
//         //$this->SetY(112);
//         $this->SetX(117);     
//         $this->MultiCell(42,5,"Heraf moms    ".$vatTotal." kr.\n\n",0,'R');

//         $this->SetX(117);
//         $this->SetFont('Arial','UB',9);
//         $this->MultiCell(42,5,iconv("UTF-8", "ISO-8859-1","Total beløb   ").$subtotal." kr.\n\n\n\n",0,'R');


         $this->SetX(20);
         $this->SetFont('Arial','',9);
         $this->MultiCell(42,5,"\n\n\nMed venlig hilsen\n\n\n",0,'L');

    }
    
    function Footer($regards)
    {
         $this->SetX(20);
         $this->SetFont('Arial','',9);
         $this->MultiCell(42,5,$regards,0,'L');
    }

    function Attachment()
    {
         $this->AddPage();
         // Read text file
         $file = "20k_c1.txt";
         $txt = file_get_contents($file);
         $txt = utf8_decode($txt);


         $this->SetX(20);
         $this->SetFont('Arial','',9);
         $this->MultiCell(160,5,$txt,0,'L');

    }


    function PrintChapter($customerName, $orderNumber, $customerKey, $customerInformation, $orderKeys, $orderInformation, $orders, $shipping, $total, $vatTotal)
    {
        $myFile = "saved_documents/testFile.txt";
        $fh = fopen($myFile, 'w') or die("can't open file");
        $stringData = 'Test '.$customerName;
        fwrite($fh, $stringData);
        fclose($fh);
        
        $this->AddPage();

        $orderKeys = iconv("UTF-8", "ISO-8859-1", $orderKeys);

        $this->InfoToCustomer($customerName, $orderNumber);
               
        
        $this->CustomerOrderInformation($customerKey,$customerInformation, $orderKeys, $orderInformation); 

      //  $orders="8-1,9-1";
        $this->OrderLines($orders, $shipping, $total, $vatTotal);

        $regards = "Bigumsoft \n";
        $regards .= "Solrød Center 5A\n";
        $regards .= "2680 Solrød Strand\n";

        $regards .= "Telefon +45 3125 7525\n";
        $regards .= "E-mail hbigum@yahoo.dk\n";

        $regards .= "www.bigumsoft.dk\n";

        $regards = iconv("UTF-8", "ISO-8859-1", $regards);

        $this->Footer($regards);

        $this->Attachment();
    }


}


//// Nedenstående kode er kun til aftestning.

//$orderNumber = "1234569";
//
//// Instanciation of inherited class
//$pdf = new PDF();
//$logoPath = 'style/logo.jpg';
//$logoLeft = 10;
//$logoDown = 2;
//$logoSize = 60;
//$title = iconv("UTF-8", "ISO-8859-1", "Ordrebekræftelse " . "- Ordrenr.: " . $orderNumber);
//$titleHeight = 9;
//$titleBorder = 1;
//$pdf->SetTitle($title);
//
//
//$customerName = 'Test Testesen';
//
//
//        $customerKey =  "Navn \n";
//        $customerKey .= "Vejnavn \n";
//        $customerKey .= "Postnr./by \n";
//        $customerKey .= "Land \n";
//        $customerKey .= "Telefon \n";
//        $customerKey .= "E-mail \n";
//
//
//        $customerInformation =  $customerName."\n";
//        $customerInformation .= "Vejnavn \n";
//        $customerInformation .= "Postnr./by \n";
//        $customerInformation .= "Land \n";
//        $customerInformation .= "Telefon \n";
//        $customerInformation .= "E-mail \n";
//
//
//        $orderKeys =  "Kundenummer \n";
//        $orderKeys .= "Ordrenr. \n";
//        $orderKeys .= "Betaling \n";
//        $orderKeys .= "Sælger \n";
//        $orderKeys .= "Vores Ref. \n";
//        $orderKeys .= "Deres Ref. \n";
//
//
//        $orderInformation = "Kundenummer \n";
//        $orderInformation .= $orderNumber."\n";
//        $orderInformation .= "Betaling \n";
//        $orderInformation .= "Henrik Bigum \n";
//        $orderInformation .= "Vores ref \n";
//        $orderInformation .= "Deres ref \n";
//
//        
//

    //    $pdf->PrintChapter('Test Testesen', $orderNumber, $customerKey, $customerInformation, $orderKeys, $orderInformation);
//
//
//$pdf->Output();


?>


