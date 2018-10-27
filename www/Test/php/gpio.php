<?php
function readpin($gpio_pin)
{
    
    //shell_exec('gpio export '.$gpio_pin.' in'); //saet port mode in/out
    //shell_exec('gpio -g write '.$gpio_pin.' 0'); //skriv vaerdi til port (kun output)
    
    $output = trim(shell_exec('gpio -g read '.$gpio_pin));
    
    
    
    if ($output == '0')
        echo "unchecked";
    else
        echo "checked";
    

} 

function writepin()
{
    
    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
    {
        
        if($_POST['ChkGPIO4'])
        {
            //shell_exec('gpio export 4 out'); //saet port mode in/out
            
            shell_exec('gpio -g write 4 1'); //skriv vaerdi til port (kun output)
        }
        else
        {
            //shell_exec('gpio export 4 out'); //saet port mode in/out
            
            shell_exec('gpio -g write 4 0'); //skriv vaerdi til port (kun output)
            
            
        } 
    }
    
 
    
}




?>