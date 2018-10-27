<?php
session_start();
	
	
	   $to = "hbigum@yahoo.dk";
	   $subj = "Mail from contact form";
	
       $name = $_POST['name'];
       $email = $_POST['email'];
	   $message = $_POST['message'];
	   
  	   
	   $headers = "Reply-To: $_POST[email]\n";
	             
  
       mail( $to,$subj, $message . " from " . $email,"From:okij@sol.dk\r\n"); 
	     

		 
		Echo "<HTML>";
		Echo "<HEAD>";
		Echo "<H1>The following e-mail has been sent:</H1>";
		Echo "</HEAD>";
		Echo "<BODY>";
		Echo "<P><strong>Your Name:</strong><br>";
		Echo "$_POST[name]";
		Echo "<P><strong>Your E-Mail Address:</strong><br>";
		Echo "$_POST[email]"; 
		Echo "<P><strong>Message:</strong><br>";
		Echo "$_POST[message]";		 
		Echo "</BODY>";
		Echo "</HTML>";
		
		header("Refresh: 4; url=http://bigumsoft.dk/index.html");

?>



