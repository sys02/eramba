<?php

include_once("header.php");
include_once("lib/site_lib.php");

$year = give_me_this_year();

echo "<table width=\"200\" border=\"0\" cellspacing=\"20\" cellpadding=\"10\" class=\"main-table\">";
echo "  <tr>";
echo "    <td>".create_Calendar(1,$year)."</th>";
echo "    <td>".create_Calendar(2,$year)."</th>";
echo "    <td>".create_Calendar(3,$year)."</th>";
echo "    <td>".create_Calendar(4,$year)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(5,$year)."</td>";
echo "    <td>".create_Calendar(6,$year)."</td>";
echo "    <td>".create_Calendar(7,$year)."</td>";
echo "    <td>".create_Calendar(8,$year)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(9,$year)."</td>";
echo "    <td>".create_Calendar(10,$year)."</td>";
echo "    <td>".create_Calendar(11,$year)."</td>";
echo "    <td>".create_Calendar(12,$year)."</td>";
echo "  </tr>";
echo "</table>";
echo "";

include_once("footer.php");
?>
