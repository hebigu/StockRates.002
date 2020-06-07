<?php



?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title>Bigumsoft</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="../text/html; charset=UTF-8" />

</head>

<body>

 
  <div id="main">
  
    <!-- begin header -->
    <header>
      <div id="logo"><h1>Bigum<a href="#">Soft</a></h1></div>
    </header>
    <!-- end header -->

    <!-- begin content -->
    <div id="site_content">
      <div id="left_content">
        <h1>Control</h1>
        <p>Enable/disable relay</p>
         <?php include '../php/gpio.php'; ?> 
        <form action="<?php writepin(); ?>" method="post">

              <div class="form_settings">
                &nbsp;<table style="width:100%;">
                      <tr>
                          <td class="auto-style29">3,3V</td>
                          <td class="auto-style22">1</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">2</td>
                          <td class="auto-style32">5V</td>
                          <td class="auto-style25" rowspan="13">
        <img src="../images/control.jpg" title="control" alt="control" /></td>
                      </tr>
                      <tr>
                          <td class="auto-style30">12C1 SDA</td>
                          <td class="auto-style23">3</td>
                          <td class="auto-style27"></td>
                          <td class="auto-style17"></td>
                          <td class="auto-style14">4</td>
                          <td class="auto-style33">5V</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">12C1 SCL</td>
                          <td class="auto-style22">5</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">6</td>
                          <td class="auto-style32">GROUND</td>
                      </tr>
                      <tr>
                          <td class="auto-style31">GPIO 4 (mode OUT)</td>
                          <td class="auto-style24">7</td>
                          <td class="auto-style28"><input id="ChkGPIO4" name="ChkGPIO4" type="checkbox"  <?php readpin('4'); ?>  /> </td>
                          <td class="auto-style18"></td>
                          <td class="auto-style15">8</td>
                          <td class="auto-style34">UART TXD</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">GROUND</td>
                          <td class="auto-style22">9</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">10</td>
                          <td class="auto-style32">UART RXD</td>
                      </tr>
                      <tr>
                          <td class="auto-style30">GPIO 17</td>
                          <td class="auto-style23">11</td>
                          <td class="auto-style27"><input id="ChkGPIO17" type="checkbox" <?php  readpin('17'); ?> /></td>
                          <td class="auto-style17"><input id="ChkGPIO18" type="checkbox" <?php  readpin('18'); ?> /></td>
                          <td class="auto-style14">12</td>
                          <td class="auto-style33">GPIO 18</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">GPIO 27</td>
                          <td class="auto-style22">13</td>
                          <td class="auto-style26"><input id="ChkGPIO27" type="checkbox" <?php  readpin('27'); ?> /></td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">14</td>
                          <td class="auto-style32">GROUND</td>
                      </tr>
                      <tr>
                          <td class="auto-style31">GPIO 22</td>
                          <td class="auto-style24">15</td>
                          <td class="auto-style28"><input id="ChkGPIO22" type="checkbox" <?php  readpin('22'); ?> /></td>
                          <td class="auto-style18"><input id="ChkGPIO23" type="checkbox" <?php  readpin('23'); ?> /></td>
                          <td class="auto-style15">16</td>
                          <td class="auto-style34">GPIO 23</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">3,3V</td>
                          <td class="auto-style22">17</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16"><input id="ChkGPIO24" type="checkbox" <?php  readpin('24'); ?> /></td>
                          <td class="auto-style13">18</td>
                          <td class="auto-style32">GPIO 24</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">SP10 MOSI</td>
                          <td class="auto-style22">19</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">20</td>
                          <td class="auto-style32">GROUND</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">SP10 MISO</td>
                          <td class="auto-style22">21</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16"><input id="ChkGPIO25" type="checkbox" <?php  readpin('25'); ?> /></td>
                          <td class="auto-style13">22</td>
                          <td class="auto-style32">GPIO 25</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">SP10 SCLK</td>
                          <td class="auto-style22">23</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">24</td>
                          <td class="auto-style32">SP10 CEO N</td>
                      </tr>
                      <tr>
                          <td class="auto-style29">GROUND</td>
                          <td class="auto-style22">25</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">26</td>
                          <td class="auto-style32">SP10 CE1 N</td>
                      </tr>
                        <tr>
                          <td class="auto-style29">&nbsp;</td>
                          <td class="auto-style22">&nbsp;</td>
                          <td class="auto-style26">&nbsp;</td>
                          <td class="auto-style16">&nbsp;</td>
                          <td class="auto-style13">&nbsp;</td>
                          <td class="auto-style32">
                          <input type="submit" value="Set" /></td>
                      </tr>
                  </table>
          </div>
        </form>
         <?php
  

        ?>
      </div>

    </div>
  </div>
 </body>

</html>


