<?php

include_once("header.php");

echo "<table width=\"200\" border=\"0\" cellspacing=\"20\" cellpadding=\"10\" class=\"main-table\">";
echo "  <tr>";
echo "    <td>".create_Calendar(1,2013)."</th>";
echo "    <td>".create_Calendar(2,2013)."</th>";
echo "    <td>".create_Calendar(3,2013)."</th>";
echo "    <td>".create_Calendar(4,2013)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(5,2013)."</td>";
echo "    <td>".create_Calendar(6,2013)."</td>";
echo "    <td>".create_Calendar(7,2013)."</td>";
echo "    <td>".create_Calendar(8,2013)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(9,2013)."</td>";
echo "    <td>".create_Calendar(10,2013)."</td>";
echo "    <td>".create_Calendar(11,2013)."</td>";
echo "    <td>".create_Calendar(12,2013)."</td>";
echo "  </tr>";
echo "</table>";
echo "";

include_once("footer.php");
?>
