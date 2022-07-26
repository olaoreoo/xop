<?php 
if (!isset($_SESSION)) {   session_start(); }
         error_reporting(1);

/*
			foreach($_SESSION["shopping_cart"] as $keys => $values)
			{

			}
*/

foreach($_SESSION as $key => $value)
{
echo $key . ' = ' . $value;
echo '<br>';
}
echo '<hr>';

 print_r($_SESSION);


echo '<hr>';
 
echo $_SESSION['userSession'];

?>