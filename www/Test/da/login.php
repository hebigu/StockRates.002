<?php
$username = $_POST["username"];
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Bigumsoft</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="../text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
  <link href="../css/colour.css" rel="stylesheet" type="text/css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="../js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">

    <!-- begin header -->
    <header>
      <div id="logo"><h1>Bigum<a href="#">Soft</a></h1></div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li><a href="index.html">Hjem</a></li>
          <li><a href="about.html">Om os</a></li>
          <li><a href="contact.html">Kontakt</a></li>
          <li class="selected"><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </header>
    <!-- end header -->

    <!-- begin content -->
    <div id="site_content">
      <div id="left_content">
        <h1>Login</h1>
        <p>Medlems login</p>
        <form action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data">
          <div class="form_settings">
            <p><span>Navn          : </span><input type="text" id="username" name="username"  /></p>
            <p><span>Kodeord        : </span><input type="password" id="password" name="passwort" /></p>
            <input type="hidden" name="Language" value="da">
            <p>&nbsp;</p>
            <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" value="login" /></p>
            <?
            if (isset($_POST['username']) && $_POST['username']!="" && isset($_POST['passwort']) && $_POST['passwort']!="")
            {
                
                            
                if ($_POST['username']=="Admin" && $_POST['passwort'] == "Kontrol")
                {     
                    echo "Hej ".$username.".<br />"; 
                    
                  //  echo "<meta http-equiv='refresh' content='0; url=http://www.bigumsoft.dk/Test/control/control.php' />";
                    echo "<meta http-equiv='refresh' content='0; url=../control/control.php' />";

                }
                    else
                        
                        echo "Du har indtastet et forkert navn eller kodeord!";   
                        
                        
                 
            }           
    

            ?>
          </div>
        </form>
      </div>
      <div id="right_content">
        <img src="../images/login.jpg" width="450" height="450" title="contact" alt="contact" />
      </div>
    </div>
    <!-- end content -->

    <!-- begin footer -->
    <footer>
<a href="../da/contact.html"> <img src="../images/dk30x30.png" alt="Danish">  </a> <a href="../en/contact.html"> <img src="../images/uk30x30.png" alt="English" > </a> 
    </footer>
    <!-- end footer -->

  </div>
 </body>
</html>
