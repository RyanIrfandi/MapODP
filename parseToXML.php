<?php

include "dbconfig.php";

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
$query = mysqli_query($con,"select * from tbl_lokasi");

$used_port=0.0;
$total_port=0.0;
$okupansi=0.0;

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

  //mendapatkan nilai okupansi
  $used_port = $row['used_port'];
  $total_port = $row['total_port'];
  $okupansi  = $used_port / $total_port * 100;


  //menentukan warna odp berdasarkan okupansi
  if ($okupansi==0) {
      $warnaOdp='hitam';
      }elseif ($okupansi<40) {
        $warnaOdp='hijau';
      }elseif ($okupansi<80) {
        $warnaOdp='kuning';
      }else{
        $warnaOdp='merah';
      }
  $newnode->setAttribute("warnaOdp", $warnaOdp);

}

echo $dom->saveXML();

?>