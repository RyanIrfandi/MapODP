<?php

include "dbconfig.php";

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
$query = mysqli_query($con,"select * from tbl_lokasi");

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = mysqli_fetch_assoc($query)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id_lokasi']);
  $newnode->setAttribute("name",$row['nama_lokasi']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("tahun", $row['tahun']);
  $newnode->setAttribute("used_port", $row['used_port']);
  $newnode->setAttribute("total_port", $row['total_port']);

}

echo $dom->saveXML();

?>