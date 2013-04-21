<?php

include_once("header.php");

echo "<table width=\"200\" border=\"0\" cellspacing=\"20\" cellpadding=\"10\">";
echo "  <tr>";
echo "    <td>".create_Calendar(01,2013)."</th>";
echo "    <td>".create_Calendar(02,2013)."</th>";
echo "    <td>".create_Calendar(03,2013)."</th>";
echo "    <td>".create_Calendar(04,2013)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(05,2013)."</td>";
echo "    <td>".create_Calendar(06,2013)."</td>";
echo "    <td>".create_Calendar(07,2013)."</td>";
echo "    <td>".create_Calendar(08,2013)."</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>".create_Calendar(09,2013)."</td>";
echo "    <td>".create_Calendar(10,2013)."</td>";
echo "    <td>".create_Calendar(11,2013)."</td>";
echo "    <td>".create_Calendar(12,2013)."</td>";
echo "  </tr>";
echo "</table>";
echo "";

include_once("footer.php");
?>
