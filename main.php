<?php
require "config.php";
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Steam Dev Games Overview!</title>
<?php
if (!$single_file)
{
	echo '<link rel="stylesheet" type="text/css" href="main.css"/>' . PHP_EOL;
	echo '<script src="main.js"></script>' . PHP_EOL;
}
else
{
	echo '<style>' . PHP_EOL;
	readfile("main.css");
	echo '</style>' . PHP_EOL;
	echo '<script>' . PHP_EOL;
	readfile("main.js");
	echo '</script>' . PHP_EOL;
}
?>
 </head>
 <body>
  <?php
require "program.php";
  ?>
 </body>
</html>
