<?php 
$id=isset($_GET['id'])?(int)$_GET['id']:0;
echo $id;
if($ph = printer_open()) 
{ 
   $content = $data; 
   printer_set_option($ph, PRINTER_MODE, "RAW"); 
   printer_write($ph, $content); 
   printer_close($ph); 
} 
else "Couldn't connect..."; 
?>